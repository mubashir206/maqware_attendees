<?php

namespace App\Models;

use Carbon\Carbon;
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
        'is_recurring',
        'recurrence_type',
        'recurrence_day',
        'recurrence_until',

    ];

    
    protected $casts = [
        'recurrence_day' => 'array', 
    ];

    public function attendees()
    {
        return $this->belongsToMany(User::class, 'attendees', 'event_id', 'user_id');
    }
       
    
    // public function isOccurringOn(Carbon $date): bool
    // {
    //     if (!$this->is_recurring || !$this->recurrence_day) {
    //         return false;
    //     }
            
    //     $dayName = $date->format('l');
        
    //     return in_array($dayName, $this->recurrence_day);
    // }



    public function isOccurringOn(Carbon $date): bool
    {
        if (!$this->is_recurring || !$this->recurrence_type) {
            return $this->start_date->isSameDay($date);
        }
        //  I'm checking that if the recrrence until is smaller then the date then return false other wise true 

        if ($this->recurrence_until && $date->greaterThan(Carbon::parse($this->recurrence_until))) {
            return false;
        }

       
    switch ($this->recurrence_type) {
        case 'daily':
            return true;

        case 'weekly':
            return in_array($date->format('l'), $this->recurrence_day);

        case 'fortnightly':
            return Carbon::parse($this->start_date)->diffInWeeks($date) % 2 === 0;

        case 'monthly':
            return Carbon::parse($this->start_date)->day === $date->day;

        case 'yearly':
            return Carbon::parse($this->start_date)->isSameDay($date);

        default:
            return false;
    }

    }

    


}
