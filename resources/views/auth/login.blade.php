@extends('layouts.app')
@section('title', __('messages.login'))
@section('content')
<div class="container py-5" style="max-width:520px">
    <div class="card border-0 shadow-sm"><div class="card-body p-4">
        <h1 class="h4 mb-3">{{ __('messages.login') }}</h1>
        <form method="post" action="{{ route('login') }}">@csrf
            <input class="form-control mb-3" name="email" type="email" value="{{ old('email') }}" placeholder="Email" required>
            <input class="form-control mb-3" name="password" type="password" placeholder="Password" required>
            <label class="form-check mb-3"><input class="form-check-input" type="checkbox" name="remember"> Remember me</label>
            <button class="btn btn-primary w-100">{{ __('messages.login') }}</button>
        </form>
        <div class="d-flex justify-content-between mt-3 small">
            <a href="{{ route('register') }}">Create account</a>
            <a href="{{ route('password.request') }}">Forgot password?</a>
        </div>
    </div></div>
</div>
@endsection
