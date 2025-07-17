<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;

class InvoicePaymentController extends Controller
{
    public function process(Request $request)
    {
        $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
        ]);

        $invoice = Invoice::find($request->invoice_id);

        if(!$invoice) {
            return response()->json([
                'status' => false,
                'message' => 'Invoice not found!.',
            ]);
        }

        // Simulate payment status
        $simulate = $request->input('simulate');
        switch ($simulate) {
            case 'success':
                $status = 'success';
                break;
            case 'fail':
                $status = 'failed';
                break;
            default:
                $status = rand(0, 1) ? 'success' : 'failed';
        }

        $invoice->status = $status;
        $invoice->save();

        return response()->json([
            'status' => true,
            'simulate' => $status,
            'message' => 'Invoice payment processed.',
        ]);
    }
}
