@extends('layouts.app')
@section('title', 'Reset password')
@section('content')
<div class="container py-5" style="max-width:520px">
    <div class="card border-0 shadow-sm"><div class="card-body p-4">
        <h1 class="h4 mb-3">Reset password</h1>
        <form method="post" action="{{ route('password.update') }}">@csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input class="form-control mb-3" name="email" type="email" value="{{ old('email', request('email')) }}" placeholder="Email" required>
            <input class="form-control mb-3" name="password" type="password" placeholder="New password" required>
            <input class="form-control mb-3" name="password_confirmation" type="password" placeholder="Confirm password" required>
            <button class="btn btn-primary w-100">Reset password</button>
        </form>
    </div></div>
</div>
@endsection
