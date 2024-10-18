<!DOCTYPE html>
<html>
<head>
    <title>Laravel 11 Fullcalender Tutorial - ItSolutionStuff.com</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
</head>
<body>

<div class="container">
    <div class="card mt-5">
        <h3 class="card-header p-3">Event full calendar</h3>
        <div class="card-body">
            <div id='calendar'></div>
        </div>
    </div>
</div>

<!-- Modal for creating events -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="eventModalLabel">Create Event</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Event Creation Form -->
          <form id="eventForm">
            @csrf
            <input type="hidden" id="start_date" name="start_date">
            <input type="hidden" id="end_date" name="end_date">

            <div class="form-group mb-3">
                <label for="title">Event Title</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="description">Event Description</label>
                <textarea id="description" name="description" class="form-control" required></textarea>
            </div>

            <div class="form-group mb-3">
                <label for="location">Event Location</label>
                <input type="text" id="location" name="location" class="form-control">
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
                <label for="status">Event Status</label>
                <select id="status" name="status" class="form-control">
                    <option value="Scheduled">Scheduled</option>
                    <option value="Ongoing">Ongoing</option>
                    <option value="Completed">Completed</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
            </div>

            <div class="form-check mb-3">
                <label class="form-check-label" for="flexCheckDefault">Is Recurring</label>
                <input type="checkbox" class="form-check-input" name="is_recurring" id="is_recurring"> 
            </div>

            <div class="form-group mb-3">
                <label for="recurrence_day">Select Recurrence Days:</label>
                <select name="recurrence_day" class="form-control" id="recurrence_day">
                    @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                        <option value="{{ $day }}">{{ $day }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="recurrence_type">Recurrence Type</label>
                <select id="recurrence_type" name="recurrence_type" id="recurrence_type" class="form-control" required>
                    <option value="none">None </option>
                    <option value="daily">Daily</option>
                    <option value="weekly">Weekly</option>
                    <option value="fortnightly">Fortnightly</option>
                    <option value="monthly">Monthly</option>
                    <option value="yearly">Yearly</option>
                </select>
            </div>

          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="saveEvent">Save Event</button>
        </div>
      </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {

        var SITEURL = "{{ url('/') }}";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var calendar = $('#calendar').fullCalendar({
            editable: true,
            events: SITEURL + "/fullcalender",
            displayEventTime: false,
            editable: true,
            selectable: true,
            selectHelper: true,

            // Open modal on select
            select: function (start, end, allDay) {
                $('#start_date').val(moment(start).format('YYYY-MM-DD'));
                $('#end_date').val(moment(end).format('YYYY-MM-DD'));
                $('#eventModal').modal('show');
            },

            eventDrop: function (event, delta) {
                var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
                var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");

                $.ajax({
                    url: SITEURL + '/fullcalenderAjax',
                    data: {
                        id: event.id,
                        title: event.title,
                        start: start,
                        end: end,
                        type: 'update'
                    },
                    type: "POST",
                    success: function (response) {
                        displayMessage("Event Updated Successfully");
                    }
                });
            },

            eventClick: function (event) {
                var deleteMsg = confirm("Do you really want to delete?");
                if (deleteMsg) {
                    $.ajax({
                        type: "POST",
                        url: SITEURL + '/fullcalenderAjax',
                        data: {
                            id: event.id,
                            type: 'delete'
                        },
                        success: function (response) {
                            calendar.fullCalendar('removeEvents', event.id);
                            displayMessage("Event Deleted Successfully");
                        }
                    });
                }
            }
        });

        // Save event on form submission
        $('#saveEvent').on('click', function () {
    var title = $('#title').val();
    var description = $('#description').val();
    var location = $('#location').val();
    var start = $('#start_date').val();
    var end = $('#end_date').val();
    var event_type = $('#event_type').val();
    var appearance = $('#appearance').val();
    var status = $('#status').val();
    var recurrence_day = $('#recurrence_day').val();
    var recurrence_type = $('#recurrence_type').val();
    var is_recurring = $('#is_recurring').val();

    if (title) {
        $.ajax({
            url: SITEURL + "/fullcalenderAjax",
            data: {
                title: title,
                description: description,
                location: location,
                event_type: event_type,
                appearance: appearance,
                status: status,
                recurrence_day: recurrence_day,
                recurrence_type: recurrence_type,
                start: start,
                end: end,
                type: 'add'
            },
            type: "POST",
            success: function (data) {
                displayMessage("Event Created Successfully");

                calendar.fullCalendar('renderEvent', {
                    id: data.id,
                    title: title,
                    start: start,
                    end: end,
                    allDay: true
                }, true);

                calendar.fullCalendar('unselect');
                $('#eventModal').modal('hide');
                $('#eventForm')[0].reset();
            },
            error: function (xhr) {
                displayMessage("Failed to create event: " + xhr.responseText);
            }
        });
    }
});

    });

    /* Toastr Success Code */
    function displayMessage(message) {
        toastr.success(message, 'Event');
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>

</body>
</html>
