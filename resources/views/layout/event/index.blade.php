@extends('layout.app')

@section('content')

    <div class="col-md-12">
        <div class="d-flex justify-content-end mb-2">
            @if(Session::has('error'))
                <div class="text-danger" role="alert">
                    {{ Session::get('error') }}
                </div>
            @endif
            @if(Session::has('success'))
                <div class="text-success" role="alert">
                    {{ Session::get('success') }}
                </div>
            @endif
            <div>
    
                <a href="{{ route('event.addPage') }}" class="btn btn-primary">Add Event</a>
            </div>
        </div>
        
        <h2 class="mt-5">Event List</h2>

        @if ($events->count() > 0)
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Description</th>                      
                        <th>Event Type</th>
                        <th>Appearance</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($events as $key => $event)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $event->name }}</td>
                            <td>{{ $event->description }}</td>

                            <td>{{ $event->event_type }}</td>
                            <td>{{ $event->appearance }}</td>
                            <td>{{ $event->location }}</td>
                            <td>{{ $event->status }}</td>
                            <td>{{ $event->start_date }}</td>
                            <td>{{ $event->end_date }}</td>
                            <td>
                                @if ($event->image)
                                    <a href="{{ asset('images/'.$event->image) }}" target="_blank" title="View the Image">
                                        <img src="{{ asset('images/'.$event->image) }}" alt="Event Image" width="100" height="100">
                                    </a>
                                @else
                                    <p>No Image</p>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('event.edit', $event->id) }}" title="Edit" class="btn btn-secondary mb-1">Edit</a>&nbsp;
                                <a href="{{ route('event.delete', $event->id) }}" onclick="return confirm('Are you sure want to delete this information')" title="Delete" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No events available.</p>
        @endif
    </div>

@endsection
