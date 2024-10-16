<?php

use App\Jobs\SendEventEmailsJob;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


// Artisan::command('event:reminder', function () {
//     Artisan::call('event:reminder');
//     $this->info("something:");
// })->everyMinute();