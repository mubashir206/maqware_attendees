<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FullCalenderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->getEvents($request->start, $request->end);
            return response()->json($data);
        }

        return view('layout.event.fullCalendar');
    }


    private function getEvents($start, $end)
    {
        
        $events = Event::where(function ($query) use ($start, $end) {
            $query->whereDate('start_date', '>=', $start)
                ->orWhereDate('end_date', '<=', $end);
        })->get();

        $allEvents = [];

        foreach ($events as $event) {
            $allEvents[] = [
                'id' => $event->id,
                'title' => $event->name,
                'start' => $event->start_date,
                'end' => $event->end_date,
            ];

            
            if ($event->is_recurring && $event->recurrence_until) {
                $recurringEvents = $this->generateRecurringEvents($event, $start, $end);
                $allEvents = array_merge($allEvents, $recurringEvents);
            }
        }

        return $allEvents;
    }


    private function generateRecurringEvents($event, $start, $end)
    {
        $recurringEvents = [];
        $eventStartDate = Carbon::parse($event->start_date);
        $currentDate = Carbon::parse($event->start_date);
        $recurrenceUntil = Carbon::parse($event->recurrence_until);
    
        while ($currentDate->lte($recurrenceUntil)) {

            if ($currentDate->gt($eventStartDate)) {

                if ($currentDate->between(Carbon::parse($start), Carbon::parse($end))) {
                    $recurringEvents[] = [
                        'id' => $event->id,
                        'title' => $event->name,
                        'start' => $currentDate->toDateString(),
                        'end' => Carbon::parse($currentDate)
                            ->addDays(Carbon::parse($event->end_date)->diffInDays($eventStartDate))
                            ->toDateString(),
                    ];
                }
            }
    
            switch ($event->recurrence_type) {
                case 'daily':
                    $currentDate->addDay();
                    break;
                case 'weekly':
                    $currentDate->addWeek();
                    break;
                case 'fortnightly':
                    $currentDate->addWeeks(2);
                    break;
                case 'monthly':
                    $currentDate->addMonth();
                    break;
                case 'yearly':
                    $currentDate->addYear();
                    break;
            }
        }
    
        return $recurringEvents;
    }
    


    public function ajax(Request $request): JsonResponse
    {
        switch ($request->type) {
            case 'add':
                $request['is_recurring'] = $request->has('is_recurring') ? 1 : 0;

                // $event = Event::create([$request->all()]);
                // dd($request->all());
                $event = Event::create([
                    'name' => $request['title'],
                    'description' => $request['description'],
                    'event_type' => $request['event_type'],
                    'appearance' => $request['appearance'],
                    'location' => $request['location'],
                    'start_date' => $request['start'],
                    'end_date' => $request['end'],
                    'status' => $request['status'],
                    'recurrence_day' => $request['recurrence_day'],
                    'recurrence_type' => $request['recurrence_type'],
                    'is_recurring' => $request['is_recurring'],
                    'recurrence_until' => $request['recurrence_until'],
                ]);

                return response()->json($event);

            case 'update':
                $event = Event::find($request->id)->update([
                    'name' => $request['title'],
                    'start_date' => $request['start'],
                    'end_date' => $request['end'],
                ]);

                return response()->json($event);

            case 'delete':
                Event::find($request->id)->delete();

                return response()->json(['success' => true]);

            default:
                return response()->json(['error' => 'Invalid event action'], 400);
        }
    }
}
