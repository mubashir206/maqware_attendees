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
    
                <a href="{{ route('attendees.addPage') }}" class="btn btn-primary">Add Attendees</a>
            </div>
        </div>
        
        <h2 class="mt-5">Attendees List</h2>

        @if ($attendees->count() > 0)
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td>#</td>
                        <th>Events</th>
                        <th>Users</th>                      
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($attendees as $key => $attendee)
                        <tr>
                            <td> {{ $key + 1 }}</td>
                            <td>{{ $attendee->event->name }}</td>
                            <td>{{ $attendee->user->name }}</td>

                            <td>
                                <a href="{{ route('attendees.edit', $attendee->id) }}" title="Edit" class="btn btn-secondary mb-1">Edit</a>&nbsp;
                                <a href="{{ route('attendees.delete', $attendee->id) }}" onclick="return confirm('Are you sure want to delete this information')" title="Delete" class="btn btn-danger">Delete</a>
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
