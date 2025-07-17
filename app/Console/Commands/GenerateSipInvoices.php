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
        $target = $now->copy()->addHours(25);

        $sips = Sip::where('status', 'active')
            ->whereDate('start_date', '<=', $target->toDateString())
            ->whereDate('end_date', '>=', $target->toDateString())
            ->get();

        \Log::info('invoice generation started', [$target->toDateString(), $sips]);

        foreach ($sips as $sip) {
            if ($sip->frequency === 'daily') {
                $scheduledDate = $target->copy()->setTime(0, 0);
            } elseif ($sip->frequency === 'monthly') {
                $day = $sip->sip_day;
                $scheduledDate = $target->copy()->setDay($day)->setTime(0, 0);
                if ($scheduledDate->month !== $target->month) continue;
            } else {
                continue;
            }

            if ($scheduledDate->lt(Carbon::parse($sip->start_date)) || $scheduledDate->gt(Carbon::parse($sip->end_date))) {
                continue;
            }

            $exists = Invoice::where('sip_id', $sip->id)
                ->whereDate('scheduled_date', $scheduledDate->toDateString())
                ->exists();
            if (!$exists) {
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
