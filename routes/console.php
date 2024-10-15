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


Schedule::call(function () {
    Log::info('Checking for events to send reminders.');

    $events = Event::where('start_date', Carbon::now()->addMinutes(5))->get();

    foreach ($events as $event) {
        Log::info("Dispatching reminder job for event: {$event->name}");
        SendEventEmailsJob::dispatch($event);
    }
})->everyMinute(); 