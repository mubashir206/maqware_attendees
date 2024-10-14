@extends('layout.app')

@section('content')

    <div class="col-md-6 offset-2">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <h2>Update Event</h2>
        
        <form action="{{ route('event.update', $event->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group mb-3">
                <label for="name">Event Name</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Enter the name..." required value="{{ old('name', $event->name) }}">
            </div>

            <div class="form-group mb-3">
                <label for="description">Event Description</label>
                <textarea id="description" name="description" class="form-control" placeholder="Enter the description..." required maxlength="150">{{ old('description', $event->description) }}</textarea>
            </div>

            <div class="form-group mb-3">
                <label for="image">Event Image</label>
                @if ($event->image)
                    <div class="mb-2">
                        <img src="{{ asset('images/' . $event->image) }}" alt="Event Image" width="200">
                    </div>
                @endif
                <input type="file" id="image" name="image" class="form-control-file" accept="image/*">
               
            </div>


            <div class="form-group mb-3">
                <label for="event_type">Event Type</label>
                <select id="event_type" name="event_type" class="form-control" required>
                    <option value="">Select Event Type</option>
                    <option value="Conference" {{ old('event_type', $event->event_type) == 'Conference' ? 'selected' : '' }}>Conference</option>
                    <option value="Entertainment" {{ old('event_type', $event->event_type) == 'Entertainment' ? 'selected' : '' }}>Entertainment</option>
                    <option value="Workshop" {{ old('event_type', $event->event_type) == 'Workshop' ? 'selected' : '' }}>Workshop</option>
                    <option value="Meetup" {{ old('event_type', $event->event_type) == 'Meetup' ? 'selected' : '' }}>Meetup</option>
                    <option value="Charity" {{ old('event_type', $event->event_type) == 'Charity' ? 'selected' : '' }}>Charity</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="appearance">Appearance Type</label>
                <select id="appearance" name="appearance" class="form-control" required>
                    <option value="">Select Appearance Type</option>
                    <option value="Physical" {{ old('appearance', $event->appearance) == 'Physical' ? 'selected' : '' }}>Physical</option>
                    <option value="Virtual" {{ old('appearance', $event->appearance) == 'Virtual' ? 'selected' : '' }}>Virtual</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="location">Event Location</label>
                <input type="text" id="location" name="location" class="form-control" value="{{ old('location', $event->location) }}">
            </div>

            <div class="form-group mb-3">
                <label for="status">Event Status</label>
                <select id="status" name="status" class="form-control">
                    <option value="Scheduled" {{ old('status', $event->status) == 'Scheduled' ? 'selected' : '' }}>Scheduled</option>
                    <option value="Ongoing" {{ old('status', $event->status) == 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                    <option value="Completed" {{ old('status', $event->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                    <option value="Cancelled" {{ old('status', $event->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>


            <div class="form-group mb-3">
                <label for="start_date">Start Date</label>
                <input type="datetime-local" id="start_date" name="start_date" class="form-control" required value="{{ old('start_date', \Carbon\Carbon::parse($event->start_date)->format('Y-m-d\TH:i')) }}">
            </div>


            <div class="form-group mb-3">
                <label for="end_date">End Date (Optional)</label>
                <input type="datetime-local" id="end_date" name="end_date" class="form-control" value="{{ old('end_date', $event->end_date ? \Carbon\Carbon::parse($event->end_date)->format('Y-m-d\TH:i') : '') }}">
            </div>

            <div class="form-group mb-3">
                <button type="submit" class="btn btn-success">Save</button>
            </div>
        </form>
    </div>

@endsection
