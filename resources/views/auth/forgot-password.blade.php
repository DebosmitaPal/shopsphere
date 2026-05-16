@extends('layouts.app')
@section('title', 'Password reset')
@section('content')
<div class="container py-5" style="max-width:520px">
    <div class="card border-0 shadow-sm"><div class="card-body p-4">
        <h1 class="h4 mb-3">Password reset</h1>
        <form method="post" action="{{ route('password.email') }}">@csrf
            <input class="form-control mb-3" name="email" type="email" value="{{ old('email') }}" placeholder="Email" required>
            <button class="btn btn-primary w-100">Email password reset link</button>
        </form>
    </div></div>
</div>
@endsection
