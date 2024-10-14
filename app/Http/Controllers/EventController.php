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
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'required',
            'event_type' => 'required',
            'appearance' => 'required',
            'location' => 'nullable',
            'status' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);
        try {

            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('images'), $imageName);
                $validatedData['image'] = $imageName;
            }

            // dd($validatedData);
            Event::create($validatedData);

            return redirect()->route('event.addPage')->with('success', 'Event added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'error foun  ');
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

        try {

            $event = Event::findOrFail($id);
            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('images'), $imageName);
                $validatedData['image'] = $imageName;
                // if ($event->image) {
                //     File::delete(public_path('images/' . $event->image));
                // }
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
