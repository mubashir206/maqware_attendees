<!DOCTYPE html>
<html>
<head>
    <title>Laravel 11 Fullcalender Tutorial Tutorial - ItSolutionStuff.com</title>
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
        <h3 class="card-header p-3">Event FullCalender</h3>
        <div class="card-body">
            <div id='calendar'></div>
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
            displayEventTime: false, // Show time along with the date
            editable: true,
            eventRender: function (event, element, view) {
                if (event.allDay === 'true') {
                    event.allDay = true;
                } else {
                    event.allDay = false;
                }
            },
            selectable: true,
            selectHelper: true,
            select: function (start, end, allDay) {
                var title = prompt('Event Title:');
                var description = prompt('Event Description:');
                var eventType = prompt('Event Type (Conference, Entertainment, Workshop, Meetup, Charity):');
                var appearance = prompt('Appearance (Physical, Virtual):');
                var location = prompt('Location:');
    
                if (title) {
                    // Format start and end to include both date and time
                    var start = $.fullCalendar.formatDate(start, "Y-MM-DD");
                    var end = $.fullCalendar.formatDate(end, "Y-MM-DD");
    
                    $.ajax({
                        url: SITEURL + "/fullcalenderAjax",
                        data: {
                            title: title,
                            description: description,
                            event_type: eventType,
                            appearance: appearance,
                            location: location,
                            start: start,
                            end: end,
                            status: 'Scheduled', // Set default status
                            type: 'add'
                        },
                        type: "POST",
                        success: function (data) {
                            displayMessage("Event Created Successfully");
    
                            calendar.fullCalendar('renderEvent',
                                {
                                    id: data.id,
                                    title: title,
                                    start: start,
                                    end: end,
                                    allDay: allDay
                                }, true);
    
                            calendar.fullCalendar('unselect');
                        }
                    });
                }
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
    
    });
    
    /* Toastr Success Code */
    function displayMessage(message) {
        toastr.success(message, 'Event');
    }
    
    </script>
    
  
</body>
</html>
