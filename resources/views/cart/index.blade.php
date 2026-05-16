@extends('layouts.app')
@section('title', __('messages.cart'))
@section('content')
<div class="container py-4">
    <h1 class="h3 mb-3">{{ __('messages.cart') }}</h1>
    @php
        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        $coupon = \App\Models\Coupon::where('code', session('coupon'))->first();
        $discount = $coupon?->discountFor($total) ?? 0;
    @endphp
    <div class="card border-0 shadow-sm"><div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead><tr><th>Product</th><th>Qty</th><th>Total</th><th></th></tr></thead>
            <tbody>
            @forelse($cartItems as $item)
                <tr>
                    <td>{{ $item->product->name }}<div class="small text-secondary">Rs. {{ $item->product->price }}</div></td>
                    <td><form method="post" action="{{ route('cart.update', $item) }}" class="d-flex gap-2">@csrf @method('patch')<input class="form-control" style="width:90px" name="quantity" type="number" value="{{ $item->quantity }}" min="1"><button class="btn btn-sm btn-outline-dark">Update</button></form></td>
                    <td>Rs. {{ number_format($item->product->price * $item->quantity, 2) }}</td>
                    <td><form method="post" action="{{ route('cart.destroy', $item) }}">@csrf @method('delete')<button class="btn btn-sm btn-outline-danger">Remove</button></form></td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center py-4">Your cart is empty.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div></div>
    <div class="row g-3 align-items-start mt-3">
        <div class="col-lg-5">
            <div class="surface p-3">
                <h2 class="h6"><i class="bi bi-ticket-perforated me-1"></i>Promo code</h2>
                <form class="d-flex gap-2" method="post" action="{{ route('cart.coupon.apply') }}">@csrf
                    <input class="form-control" name="code" value="{{ session('coupon') }}" placeholder="Try SPHERE10 or FREESHIP">
                    <button class="btn btn-dark">Apply</button>
                </form>
                @if($coupon)
                    <form method="post" action="{{ route('cart.coupon.remove') }}" class="mt-2">@csrf @method('delete')<button class="btn btn-sm btn-link p-0">Remove {{ $coupon->code }}</button></form>
                @endif
            </div>
        </div>
        <div class="col-lg-7 text-lg-end">
            <div class="surface p-3">
                <div>Subtotal: <strong>Rs. {{ number_format($total, 2) }}</strong></div>
                <div class="text-success">Discount: - Rs. {{ number_format($discount, 2) }}</div>
                <h2 class="h5 mt-2">Estimated total: Rs. {{ number_format(max(0, $total - $discount), 2) }}</h2>
                <a class="btn btn-primary" href="{{ route('checkout.create') }}">{{ __('messages.checkout') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection
