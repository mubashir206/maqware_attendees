@extends('layout.app', ['activePage' => 'attendees'])

@section('content')

    <div class="col-md-6 offset-2">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <h2>Update Attendees</h2>
        <form action="{{ route('attendees.update', $attendee->id) }}" method="POST">
            @csrf

            <div class="form-group mb-3">
                <label for="user_id">Users</label>
                <select id="user_id" name="user_id" class="form-select select2" required>
                    <option value="">Select Users</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $attendee->user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>


            <div class="form-group mb-3">
                <label for="event_id">Events</label>
                <select id="event_id" name="event_id" class="form-select select2" required>
                    <option value="">Select Events</option>
                    @foreach ($events as $event)
                        <option value="{{ $event->id }}" {{ $attendee->event_id == $event->id ? 'selected' : '' }}>
                            {{ $event->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-4">
                <button type="submit" class="btn btn-success mb-4">Save</button>
            </div>
        </form>
    </div>

    <!-- Include Select2 JS (Uncomment these lines) -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
    <script>
        $(document).ready(function() {
            $('.select2').select2(); // Initialize Select2
        });
    </script>

@endsection
