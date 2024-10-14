<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use App\Models\Event;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\CssSelector\Node\FunctionNode;

class AttendeesController extends Controller
{
    public function index(){
        $attendees= Attendee::all();
        return view('layout.attendees.index', compact('attendees'));
    }

    public function addPage(){
        $users = User::all();
        $events = Event::all();
        return view('layout.attendees.add')->with(compact('users', 'events'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'event_id' => 'required|exists:events,id',
        ]);

        try{
            
        
            $user = User::findOrFail($validated['user_id']);
            $event = Event::findOrFail($validated['event_id']);
        
            $event->users()->attach($user->id);
            return redirect()->back()->with('success', 'The attendees inserted successfully !');

        }catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function edit($id){
        $attendee = Attendee::find($id);
        $users = User::all();
        $events = Event::all();
        return view('layout.attendees.edit')->with(compact('users', 'events', 'attendee'));
    }

    public function update(Request $request, $id)
    {
        // dd("tis is ");
    
        $validated = $request->validate([
            'user_id' => 'required',
            'event_id' => 'required',
        ]);

        $attendee = Attendee::findOrFail($id);

        $attendee->user_id = $validated['user_id'];
        $attendee->event_id = $validated['event_id'];
        // dd($attendee);
        $attendee->save();
        return redirect()->back()->with('success', 'The attendees updated successfully !');

    }

    public function delete($id)
    {
        $Attendee = Attendee::find($id);
        if (!$Attendee) {
            return redirect()->back()->with('error', 'Attendee not found.');
        }
        // dd($Attendee);
        $Attendee->delete();
        return redirect()->back()->with('success', 'Information Deleted successfully!');
    }
}
