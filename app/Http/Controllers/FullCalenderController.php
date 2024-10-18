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
                $event = Event::create([
                    'name' => $request->title,
                    'description' => $request->description,
                    'event_type' => $request->event_type,
                    'appearance' => $request->appearance,
                    'location' => $request->location,
                    'start_date' => $request->start,
                    'end_date' => $request->end,
                    'status' => $request->status ?? 'Scheduled',
                ]);
    
                return response()->json($event);
                break;
    
                case 'update':
                    $event = Event::find($request->id)->update([
                        'name' => $request->title,
                        'start_date' => $request->start,
                        'end_date' => $request->end,
                    ]);
    
                return response()->json($event);
                break;
    
            case 'delete':
                $event = Event::find($request->id)->delete();
    
                return response()->json($event);
                break;
    
            default:
                return response()->json(['error' => 'Invalid event action']);
        }
    }
}
