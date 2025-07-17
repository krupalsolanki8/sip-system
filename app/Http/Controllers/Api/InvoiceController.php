<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::where('user_id', Auth::id())->with('sip')->get();
        return response()->json([
            'status' => true,
            'message' => 'Invoices fetched successfully.',
            'data' => $invoices,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $invoice = Invoice::where('user_id', Auth::id())->with('sip')->find($id);

        if(!$invoice) {
            return response()->json([
                'status' => false,
                'message' => 'No Invoice found!.',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Invoice fetched successfully.',
            'data' => $invoice,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
