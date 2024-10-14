<?php

namespace App\Jobs;

use App\Models\Event;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendEventEmailsJob implements ShouldQueue
{
    use Queueable;
    public $eventId;

    /**
     * Create a new job instance.
     */
    public function __construct($eventId)
    {
        $this->eventId =   $eventId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $event = Event::find($this->eventId);
        $attendees = $event->attendees;

        foreach ($attendees as $attendee) {
            Mail::to($attendee->email)->send(new \App\Mail\EventReminderMail($event));
            info('mail to'. $attendee->email);
        }
    }
}
