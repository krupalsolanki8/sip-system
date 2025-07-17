<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class InvoiceController extends Controller
{
    public function index()
    {
        return view('invoices.index');
    }

    public function datatable()
    {
        $query = Invoice::where('user_id', Auth::id())->with('sip');
        return DataTables::of($query)
            ->editColumn('status', function($invoice) {
                return ucfirst($invoice->status);
            })
            ->make(true);
    }

    public function download($id)
    {
        $invoice = Invoice::where('user_id', Auth::id())->findOrFail($id);
        $pdfPath = storage_path('app/invoices/invoice_' . $invoice->id . '.pdf');
        if (!file_exists($pdfPath)) {
            abort(404, 'Invoice PDF not found.');
        }
        return response()->download($pdfPath, 'Invoice_' . $invoice->id . '.pdf');
    }
}
