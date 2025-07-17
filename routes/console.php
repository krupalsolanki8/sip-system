<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('queue:work --stop-when-empty')->everyMinute()
    ->appendOutputTo(storage_path('logs/scheduler.log'));

Schedule::command('sip:generate-invoices')->hourlyAt(0)
    ->appendOutputTo(storage_path('logs/scheduler.log'));

Schedule::command('sip:process-invoices')->hourlyAt(5)
    ->appendOutputTo(storage_path('logs/scheduler.log'));

Schedule::command('sip:sync-status')->dailyAt('00:00')
    ->appendOutputTo(storage_path('logs/scheduler.log'));