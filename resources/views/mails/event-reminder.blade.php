<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Event reminder</title>
</head>
<body>
    <h1>{{ $event->name }}</h1>
    <p>This is a reminder that your event is starting soon.</p>
    <p>Start Time: {{ $event->start_time->format('F j, Y, g:i a') }}</p>
</body>
</html>