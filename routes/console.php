<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule assessment reminders to be sent daily at 9 AM
Schedule::command('app:send-assessment-reminders')
    ->dailyAt('09:00')
    ->timezone('Asia/Jakarta');

// Schedule Weekly Report for Admin (Every Monday at 8 AM)
Schedule::command('app:send-weekly-report')
    ->weeklyOn(1, '08:00')
    ->timezone('Asia/Jakarta');
