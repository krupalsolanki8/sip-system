<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('sip:generate-invoices')->hourlyAt(0)
    ->appendOutputTo(storage_path('logs/scheduler.log'));

Schedule::command('sip:process-invoices')->hourlyAt(5)
    ->appendOutputTo(storage_path('logs/scheduler.log'));

Schedule::command('sip:sync-status')->dailyAt('00:00')
    ->appendOutputTo(storage_path('logs/scheduler.log'));