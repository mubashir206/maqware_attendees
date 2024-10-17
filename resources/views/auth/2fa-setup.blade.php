@extends('layout.app')

@section('content')
    <div class="container mt-5">
        <h2>2FA Setup</h2>
        <p>Scan the QR code below with your authenticator app.</p>
        <div class="qr-code">
            {!! $qrCode !!}
        </div>
        <p>Or manually enter the key: <strong>{{ $google2faSecret }}</strong></p>
        <p>otp: <strong>{{ $otp }}</strong></p>

        <a href="{{ route('loginPage') }}" class="btn btn-primary mt-3">Proceed to Login</a>
    </div>
@endsection
