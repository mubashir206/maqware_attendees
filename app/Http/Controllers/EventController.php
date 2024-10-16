<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        $data = compact('events');
        return view('layout.event.index')->with($data);
    }

    public function addpage()
    {

        return view('layout.event.add');
    }

    public function store(Request $request)
    {
        // dd("all googe");
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'nullable',
            'event_type' => 'required',
            'appearance' => 'required',
            'location' => 'nullable',
            'status' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_recurring' => 'nullable',
            'recurrence_day' => 'nullable',
             'attendees' => 'nullable'
        ]);

        try {
            $validatedData['is_recurring'] = $request->has('is_recurring') ? 1 : 0;

            if ($request->hasFile('image')) {

                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('images'), $imageName);
                $validatedData['image'] = $imageName;
            }
            
            
           $event =  Event::create($validatedData);
           
           if ($request->has('attendees')) {
            $event->attendees()->sync($validatedData['attendees']);
        }
           
        //    dd($event);

            return redirect()->route('event.addPage')->with('success', 'Event added successfully!');
        } catch (\Exception $e) {
            // return redirect()->back()->with('error', 'error foun  ');
            dd("Error: " . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $event = Event::find($id);
        $data = compact('event');
        return view('layout.event.edit')->with($data);
    }


    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'event_type' => 'required',
            'appearance' => 'required',
            'location' => 'nullable',
            'status' => 'required',
            'start_date' => 'required',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'image' => 'nullable',
            
        ]);
        dd($validatedData);

        try {

            $event = Event::findOrFail($id);
            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('images'), $imageName);
                $validatedData['image'] = $imageName;
            }

            // dd($validatedData);
            $event->update($validatedData);

            return redirect()->route('event.edit', $id)->with('success', 'Event updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'error foun  ');
        }
    }

    public function delete($id)
    {
        $event = Event::find($id);
        if (!$event) {
            return redirect()->back()->with('error', 'Event not found.');
        }
        // dd($event);
        $event->delete();
        return redirect()->back()->with('success', 'Information Deleted successfully!');
    }
}
