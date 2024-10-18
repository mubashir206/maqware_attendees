<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FullCalenderController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $data = Event::whereDate('start_date', '>=', $request->start)
                ->whereDate('end_date',   '<=', $request->end)
                ->get(['id', 'name as title', 'start_date as start', 'end_date as end']);

            return response()->json($data);
        }

        return view('layout.event.fullCalendar');
    }


    public function ajax(Request $request): JsonResponse
    {
    
        switch ($request->type) {
            case 'add':
                
                $request['is_recurring'] = $request->has('is_recurring') ? 1 : 0;

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
