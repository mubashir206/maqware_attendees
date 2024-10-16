<?php

namespace App\Console\Commands;

use App\Jobs\SendEventEmailsJob;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Console\Command;
use Psy\Readline\Hoa\Console;

class ReminderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'event:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders 5 minutes before event start time';

    /**
     * Execute the console command.
     */
    public function handle()
    {
       // $events = Event::where('is_recurring', true)->get();

        // $events = Event::where('recurrence_day', Carbon::now()->format('l'))
        //->where('is_recurring', true)->get();

        // we can also these two method for getting the event on the base of days, recurring, other login 



            $startTime = Carbon::now()->subMinutes(5)->format('H:i:s');
            $endTime = Carbon::now()->format('H:i:s');

            $events = Event::whereRaw("TIME(start_date) BETWEEN ? AND ?", [$startTime, $endTime])
                ->where('is_recurring', true)
                ->get();

        dd($events, "somethig is found....");
        foreach ($events as $event) {
            if ($event->isOccurringOn(Carbon::now())) {
            $this->info("Dispatching reminder job: {$event->name}");
            SendEventEmailsJob::dispatch($event);
            }
        }


        return Command::SUCCESS;
    }
}
