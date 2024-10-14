<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Verify Two-Factor Authentication</h1>
<form method="POST" action="{{ route('2fa.verify') }}">
    @csrf
    <label for="2fa_code">Enter the 6-digit code from your Google Authenticator app:</label>
    <input type="text" name="2fa_code" required>
    <button type="submit">Verify</button>
</form>

</body>
</html>