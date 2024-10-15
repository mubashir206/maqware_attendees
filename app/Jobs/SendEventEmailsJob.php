<?php

namespace App\Jobs;

use App\Mail\EventReminderMail;
use App\Models\Event;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendEventEmailsJob implements ShouldQueue
{
    use Queueable;
    public $event;

    /**
     * Create a new job instance.
     */
    public function __construct(Event $event)
    {
        $this->event =   $event;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        
        foreach ($this->event->attendees as $attendee) {
            Mail::to($attendee->email)->send(new EventReminderMail($this->event));
        }
    }
}
