<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'event_type',
        'appearance',
        'location',
        'status',
        'start_date',
        'end_date',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'attendees', 'event_id', 'user_id');
    }
    
    // public function scheduleEmailNotification()
    // {
    //     $job = (new \App\Jobs\SendEventEmailsJob($this->id))
    //             ->delay($this->start_time->subMinutes(5));
    //     dispatch($job);
    // }
}
