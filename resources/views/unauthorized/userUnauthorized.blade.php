<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Unauthorized Access</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container d-flex align-items-center justify-content-center vh-100">
  <div class="text-center">
    <h1 class="display-1 text-danger">403</h1>
    <h2 class="mb-4">Unauthorized Access</h2>
    <p class="lead">Sorry, you are not authorized to access this page.</p>
    <a href="{{ route('loginPage') }}" class="btn btn-primary">Login</a>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
