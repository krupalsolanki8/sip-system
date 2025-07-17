<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Sip;
use App\Models\Invoice;
use Illuminate\Support\Carbon;

class GenerateSipInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sip:generate-invoices';

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
        $now = Carbon::now();
        // Define the target time (25 hours from now)
        $target = $now->copy()->addHours(25);

        // Fetch all active SIPs whose start and end dates include the target date
        $sips = Sip::where('status', 'active')
            ->whereDate('start_date', '<=', $target->toDateString())
            ->whereDate('end_date', '>=', $target->toDateString())
            ->get();

        foreach ($sips as $sip) {
            if ($sip->frequency === 'daily') {
                // For daily SIPs, schedule the invoice for the next day
                $scheduledDate = $target->copy()->setTime(0, 0);

            } elseif ($sip->frequency === 'monthly') {
                // For monthly SIPs, determine the next SIP date
                $year = $now->year;
                $month = $now->month;
                $day = $sip->sip_day;

                // Create the next SIP date for this month
                $nextSipDate = Carbon::createSafe($year, $month, $day, 0, 0, 0);
                if (!$nextSipDate) continue; // Skip if invalid date (e.g., Feb 30)

                // If today is on or after this month's SIP day, move to next month's SIP day
                if ($now->greaterThanOrEqualTo($nextSipDate)) {
                    $nextSipDate = $nextSipDate->addMonth();
                }

                // Only generate the invoice if the next SIP date is within the next 25 hours
                if (!$nextSipDate->between($now->copy()->addSecond(), $now->copy()->addHours(25))) {
                    continue;
                }

                $scheduledDate = $nextSipDate;

            } else {
                continue;
            }

            // Ensure the scheduled date is within the SIP's start and end dates
            if ($scheduledDate->lt(Carbon::parse($sip->start_date)) || $scheduledDate->gt(Carbon::parse($sip->end_date))) {
                continue;
            }

            // Check if an invoice already exists for this SIP and scheduled date
            $exists = Invoice::where('sip_id', $sip->id)
                ->whereDate('scheduled_date', $scheduledDate->toDateString())
                ->exists();

            if (!$exists) {
                // Create the invoice if it doesn't already exist
                Invoice::create([
                    'sip_id' => $sip->id,
                    'user_id' => $sip->user_id,
                    'amount' => $sip->amount,
                    'status' => 'pending',
                    'scheduled_date' => $scheduledDate,
                ]);

                $this->info("Invoice created for SIP #{$sip->id} on {$scheduledDate->toDateString()}");
            }
        }
    }
}
