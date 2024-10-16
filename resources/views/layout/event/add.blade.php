@extends('layout.app')

@section('content')

        <div class="col-md-6 offset-2">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            <h2>Add Event</h2>
            <form action="{{ route('event.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group mb-3">
                    <label for="name">Event Name</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Enter the name..." required>
                </div>

                <div class="form-group mb-3">
                    <label for="description">Event Description</label>
                    <textarea id="description" name="description" class="form-control" placeholder="Enter ther description..." required maxlength="150"></textarea>
                </div>

                <div class="form-group mb-3">
                    <label for="image">Event Image</label>
                    <input type="file" id="image" name="image" class="form-control-file"  accept="image/*">
                </div>

                <div class="form-group mb-3">
                    <label for="event_type">Event Type</label>
                    <select id="event_type" name="event_type" class="form-control" required>
                        <option value="">Select Event Type </option>
                        <option value="Conference">Conference</option>
                        <option value="Entertainment">Entertainment</option>
                        <option value="Workshop">Workshop</option>
                        <option value="Meetup">Meetup</option>
                        <option value="Charity">Charity</option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="appearance">Appearance Type</label>
                    <select id="appearance" name="appearance" class="form-control" required>
                        <option value=""> Select Appearance Type </option>
                        <option value="Physical">Physical</option>
                        <option value="Virtual">Virtual</option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="location">Event Location</label>
                    <input type="text" id="location" name="location" class="form-control">
                </div>

                <div class="form-group mb-3">
                    <label for="status">Event Status</label>
                    <select id="status" name="status" class="form-control">
                        <option value="Scheduled">Scheduled</option>
                        <option value="Ongoing">Ongoing</option>
                        <option value="Completed">Completed</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                </div>

    
                <div class="form-group mb-3">
                    <label for="start_date">Start Date</label>
                    <input type="datetime-local" id="start_date" name="start_date" class="form-control" required>
                </div>

           
                <div class="form-group mb-3">
                    <label for="end_date">End Date(Optional)</label>
                    <input type="datetime-local" id="end_date" name="end_date" class="form-control">
                </div>

                <div class="form-check mb-3">
                    <label class="form-check-label" for="flexCheckDefault">Is Recurring</label>
                    <input type="checkbox" class="form-check-input" name="is_recurring" id="flexCheckDefault"> 
                </div>

                <div class="form-group mb-3">
                    <label for="recurrence_day">Select Recurrence Days:</label>
                    <select name="recurrence_day" class="form-control">
                        @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                            <option value="{{ $day }}">{{ $day }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-3">
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>

@endsection
