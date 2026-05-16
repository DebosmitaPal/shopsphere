@extends('layouts.app')
@section('title', __('messages.register'))
@section('content')
<div class="container py-5" style="max-width:560px">
    <div class="card border-0 shadow-sm"><div class="card-body p-4">
        <h1 class="h4 mb-3">{{ __('messages.register') }}</h1>
        <form method="post" action="{{ route('register') }}">@csrf
            <input class="form-control mb-3" name="name" value="{{ old('name') }}" placeholder="Name" required>
            <input class="form-control mb-3" name="email" type="email" value="{{ old('email') }}" placeholder="Email" required>
            <input class="form-control mb-3" name="password" type="password" placeholder="Password" required>
            <input class="form-control mb-3" name="password_confirmation" type="password" placeholder="Confirm password" required>
            <button class="btn btn-primary w-100">{{ __('messages.register') }}</button>
        </form>
    </div></div>
</div>
@endsection
