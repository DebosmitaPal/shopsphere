@extends('layouts.app')
@section('title', 'Profile')
@section('content')
<div class="container py-4" style="max-width:720px">
    <h1 class="h3 mb-3">Profile</h1>
    <form class="card border-0 shadow-sm" method="post" action="{{ route('profile.update') }}">@csrf @method('patch')
        <div class="card-body row g-3">
            <div class="col-md-6"><input class="form-control" name="name" value="{{ old('name', $user->name) }}" required></div>
            <div class="col-md-6"><input class="form-control" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Phone"></div>
            <div class="col-12"><textarea class="form-control" name="address" rows="4" placeholder="Address">{{ old('address', $user->address) }}</textarea></div>
            <div class="col-12"><button class="btn btn-primary">Save profile</button></div>
        </div>
    </form>
</div>
@endsection
