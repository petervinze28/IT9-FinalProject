@extends('layouts.guest', ['title' => 'Login | CleanTrack'])

@section('content')
<form method="POST" action="{{ route('login.store') }}" class="auth-form">
    @csrf
    <label>
        <span>Email</span>
        <input type="email" name="email" value="{{ old('email') }}" placeholder="admin@cleantrack.com" required autofocus>
    </label>

    <label>
        <span>Password</span>
        <input type="password" name="password" placeholder="password" required>
    </label>

    <label class="remember-row">
        <input type="checkbox" name="remember" value="1">
        <span>Remember me</span>
    </label>

    <button type="submit" class="btn-primary auth-button">Login</button>

</form>
@endsection
