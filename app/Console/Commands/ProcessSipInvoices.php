<?php

namespace App\Console\Commands;

use App\Events\InvoiceFailed;
use Illuminate\Console\Command;
use App\Models\Invoice;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use App\Events\InvoicePaid;
use App\Services\InvoicePdfService;

class ProcessSipInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sip:process-invoices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        \Log::info('invoice process started');

        // $cutoff = Carbon::now()->subHours(25); // update invoice delay
        $now = Carbon::now();

        $pendingInvoices = Invoice::where('status', 'pending')
            ->where('scheduled_date', '<=', $now)
            ->get();

        foreach ($pendingInvoices as $invoice) {
            // Call the fake api to update invoice status
            // Note: In a real scenario, it will be updated when the SIP payment is debited.

            $apiUrl = config('app.url') . '/api/invoices/process-payment';
            $response = Http::post($apiUrl, [
                'invoice_id' => $invoice->id,
            ]);
            
            if ($response->ok()) {
                $status = $response->json('status');
                $this->info("Invoice #{$invoice->id} processed: {$status}");
                if ($status === 'success') {
                    // Reload the invoice to get the updated status
                    $invoice->refresh();
                    // Generate and store PDF invoice using the service
                    app(InvoicePdfService::class)->generate($invoice);
                    event(new InvoicePaid($invoice->user, $invoice));
                } elseif ($status === 'failed') {
                    $invoice->refresh();
                    event(new InvoiceFailed($invoice->user, $invoice));
                }
            } else {
                $this->error("Failed to process invoice #{$invoice->id}");
            }
        }
    }
}
