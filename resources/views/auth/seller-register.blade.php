@extends('layouts.app')
@section('title', __('messages.become_seller'))
@section('content')
<div class="container py-5" style="max-width:720px">
    <div class="card border-0 shadow-sm"><div class="card-body p-4">
        <h1 class="h4 mb-3">{{ __('messages.become_seller') }}</h1>
        <form method="post" action="{{ route('seller.register') }}">@csrf
            <div class="row g-3">
                <div class="col-md-6"><input class="form-control" name="name" value="{{ old('name') }}" placeholder="Owner name" required></div>
                <div class="col-md-6"><input class="form-control" name="email" type="email" value="{{ old('email') }}" placeholder="Login email" required></div>
                <div class="col-md-6"><input class="form-control" name="store_name" value="{{ old('store_name') }}" placeholder="Store name" required></div>
                <div class="col-md-6"><input class="form-control" name="business_email" type="email" value="{{ old('business_email') }}" placeholder="Business email"></div>
                <div class="col-md-6"><input class="form-control" name="password" type="password" placeholder="Password" required></div>
                <div class="col-md-6"><input class="form-control" name="password_confirmation" type="password" placeholder="Confirm password" required></div>
                <div class="col-12"><textarea class="form-control" name="description" rows="3" placeholder="Store description">{{ old('description') }}</textarea></div>
            </div>
            <button class="btn btn-primary mt-3">{{ __('messages.submit_for_approval') }}</button>
        </form>
    </div></div>
</div>
@endsection
