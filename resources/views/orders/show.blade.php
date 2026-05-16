@extends('layouts.app')
@section('title', $order->order_number)
@section('content')
<div class="container py-4">
    <h1 class="h3">{{ $order->order_number }}</h1>
    <p class="text-secondary">Tracking status: <strong>{{ ucfirst($order->status) }}</strong></p>
    <div class="card border-0 shadow-sm"><div class="card-body">
        @foreach($order->items as $item)
            <div class="d-flex justify-content-between border-bottom py-2"><span>{{ $item->product->name }} x {{ $item->quantity }}</span><strong>Rs. {{ $item->total }}</strong></div>
        @endforeach
        <div class="text-end mt-3"><h2 class="h5">Total: Rs. {{ $order->total }}</h2></div>
    </div></div>
</div>
@endsection
