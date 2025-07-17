<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Sip;

class SyncSipStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sip:sync-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync all SIP statuses based on current date and SIP period.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = 0;
        Sip::chunk(100, function ($sips) use (&$count) {
            foreach ($sips as $sip) {
                $sip->syncStatus();
                $count++;
            }
        });
        $this->info("Synced status for {$count} SIP(s).");
    }
} 