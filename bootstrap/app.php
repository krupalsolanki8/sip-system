<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->respond(function (\Symfony\Component\HttpFoundation\Response $response, $e, \Illuminate\Http\Request $request) {
        
            if ($request->is('api/*')) {

                $message = $e->getMessage();

                // \Log::error('Unhandled exception occurred', [
                //     'message' => $message,
                //     'file' => $e->getFile(),
                //     'line' => $e->getLine(),
                // ]);

                // \Log::debug('Caught exception: ' . get_class($e));
                
                if ($e instanceof \Illuminate\Auth\AuthenticationException) {
                    return response()->json([
                        'status' => false,
                        'message' => __('Unauthenticated.'),
                    ], 401);
                }

                if($e instanceof \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException) {
                    return response()->json([
                        'status' => false,
                        'message' => __('You are not authorized to perform this action.'),
                    ], 403);
                }

                if ($e instanceof \Illuminate\Auth\Access\AuthorizationException) {
                    return response()->json([
                        'status' => false,
                        'message' => __('This action is unauthorized.'),
                    ], 403);
                }

                if ($e instanceof \ErrorException) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Something went wrong. Please try again later.',
                    ], 500);
                }

                return response()->json([
                    'status' => false,
                    'message' => $message,
                ], 500);
            }

            return $response;
        });
    })->create();
