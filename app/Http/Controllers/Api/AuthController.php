<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use App\Http\Requests\Api\LoginRequest;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => ['required', 'confirmed', Password::defaults()],
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation failed.',
                    'data' => $validator->errors(),
                ], 422);
            }
            
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            try {
                event(new Registered($user));
            } catch (\Exception $e) {
                \Log::error('Failed to send verification email: ' . $e->getMessage());
            }

            $token = $user->createToken('authToken')->accessToken;
            return response()->json([
                'status' => true,
                'message' => 'Registration successful.',
                'data' => [
                    'token' => $token,
                    'user' => $user,
                ],
            ], 201);
        } catch (\Exception $e) {
            \Log::error('User registration failed.', ['message' => $e->getMessage()]);

            return response()->json([
                'status' => false,
                'message' => 'Registration failed. Please try again..',
            ], 500);
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid credentials',
                ], 401);
            }

            $user = Auth::user();
            $token = $user->createToken('authToken')->accessToken;

            return response()->json([
                'status' => true,
                'message' => 'Login successful.',
                'data' => [
                    'token' => $token,
                    'user' => $user->load('sips'),
                ],
            ]);
        } catch (\Exception $e) {
            \Log::error('Login Error', ['message' => $e->getMessage()]);

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong, please try again!',
            ]);            
        }
    }

    public function logout(Request $request)
    {
        try {
            $user = $request->user() ?? null;

            if ($user && $user->token()) {
                $user->token()->revoke();
                return response()->json([
                    'status' => true,
                    'message' => 'Logged out successfully.',
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Logout failed: ', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => false,
                'message' => 'Failed to logout. Please try again.'
            ], 500);
        }
    }

    public function user(Request $request)
    {
        $user = $request->user();
        
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found.'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Profile fetched successfully.',
            'data' => $request->user(),
        ]);
    }
}
