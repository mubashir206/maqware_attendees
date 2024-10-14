@extends('layout.app')

@section('content')

        <div class="col-md-6 offset-2">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
            <h2>Add Attendess</h2>
            <form action="{{ route('attendees.store') }}" method="POST">
                @csrf


                <div class="form-group mb-3">
                    <label for="user_id">Users</label>
                    <select id="user_id" name="user_id" class="form-select select2"  required>
                        <option value="">Select Users</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group mb-3">
                    <label for="event_id">Events</label>
                    <select id="event_id" name="event_id" class="form-select select2"  required>
                        <option value="">Select Events</option>
                        @foreach ($events as $event)
                            <option value="{{ $event->id }}">{{ $event->name }}</option>
                        @endforeach
                    </select>
                </div>
                

                <div class="form-group mb-4">
                    <button type="submit" class="btn btn-success mb-4">Save</button>
                </div>
            </form>
        </div>
 <!-- Select2 CSS -->
{{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}

<!-- Select2 JS -->
{{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
          $(document).ready(function() {
            $('.select2').select2();
            });
        </script> --}}
        

@endsection
