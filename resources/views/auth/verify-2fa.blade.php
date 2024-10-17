@extends('layout.app')

@section('content')
    <div class="col-md-6 offset-2 my-5">
        <h2>Verify 2FA</h2>

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('verify2fa') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="otp">Enter OTP</label>
                <input type="text" id="otp" name="otp" class="form-control" placeholder="Enter the 6-digit code" required>
            </div>

            <button type="submit" class="btn btn-primary">Verify</button>
        </form>
    </div>
@endsection
