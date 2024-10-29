<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Event reminder</title>
</head>
<body>
    <h1>Upcoming Event Reminder</h1>
    <p>The event <strong>{{ $event->name }}</strong> is starting soon.</p>
    <p>Start Time: {{ $event->start_date }}</p>
</body>
</html>