<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote')->hourly();

// Schedule::command('test:cron')->everyFiveMinutes();
// Schedule::command('delete:pending-records')->dailyAt('20:15');
// Schedule::command('delete:pending-records')->everyFiveMinutes();
Schedule::command('test:cron')->everyFiveMinutes();