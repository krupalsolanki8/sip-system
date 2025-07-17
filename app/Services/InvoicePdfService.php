<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use App\Models\Invoice;

class InvoicePdfService
{
    public function generate(Invoice $invoice)
    {
        $pdf = Pdf::loadView('invoices.pdf', [
            'user' => $invoice->user,
            'invoice' => $invoice,
            'app_name' => config('app.name', 'SIP System'),
        ]);
        $pdfPath = 'invoices/invoice_' . $invoice->id . '.pdf';
        Storage::put($pdfPath, $pdf->output());
        return $pdfPath;
    }
} 