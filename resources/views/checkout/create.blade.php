@extends('layouts.app')
@section('title', __('messages.checkout'))
@section('content')
<div class="container py-4" style="max-width:920px">
    <h1 class="h3 mb-3">{{ __('messages.checkout') }}</h1>
    <div class="row g-4">
        <div class="col-lg-7">
            <form class="surface p-4" method="post" action="{{ route('checkout.store') }}">@csrf
                <label class="form-label">Shipping address</label>
                <textarea class="form-control mb-3" name="shipping_address" rows="4" required>{{ old('shipping_address', auth()->user()->address) }}</textarea>
                <label class="form-label">Payment method</label>
                <select class="form-select mb-3" name="payment_method"><option value="cod">Cash on delivery</option><option value="card">Card</option><option value="upi">UPI</option></select>
                <button class="btn btn-primary"><i class="bi bi-shield-check me-1"></i>{{ __('messages.place_order') }}</button>
            </form>
        </div>
        <div class="col-lg-5">
            @php($tax = round($subtotal * 0.05, 2))
            @php($shipping = $subtotal > 2000 ? 0 : 99)
            <div class="surface p-4">
                <h2 class="h5">Order summary</h2>
                <div class="d-flex justify-content-between py-2 border-bottom"><span>Subtotal</span><strong>Rs. {{ number_format($subtotal, 2) }}</strong></div>
                <div class="d-flex justify-content-between py-2 border-bottom text-success"><span>Coupon {{ $coupon?->code }}</span><strong>- Rs. {{ number_format($discount, 2) }}</strong></div>
                <div class="d-flex justify-content-between py-2 border-bottom"><span>Tax</span><strong>Rs. {{ number_format($tax, 2) }}</strong></div>
                <div class="d-flex justify-content-between py-2 border-bottom"><span>Shipping</span><strong>Rs. {{ number_format($shipping, 2) }}</strong></div>
                <div class="d-flex justify-content-between pt-3"><span>Total</span><strong>Rs. {{ number_format(max(0, $subtotal - $discount) + $tax + $shipping, 2) }}</strong></div>
            </div>
        </div>
    </div>
</div>
@endsection
