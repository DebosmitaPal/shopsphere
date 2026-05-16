@extends('layouts.app')
@section('title', __('messages.orders'))
@section('content')
<div class="container py-4">
    <h1 class="h3 mb-3">{{ __('messages.orders') }}</h1>
    <div class="card border-0 shadow-sm"><div class="table-responsive"><table class="table align-middle mb-0">
        <thead><tr><th>Order</th><th>Status</th><th>Total</th><th>Date</th><th></th></tr></thead>
        <tbody>@foreach($orders as $order)<tr><td>{{ $order->order_number }}</td><td><span class="badge bg-info">{{ $order->status }}</span></td><td>Rs. {{ $order->total }}</td><td>{{ $order->created_at->format('d M Y') }}</td><td><a href="{{ route('orders.show', $order) }}">Track</a></td></tr>@endforeach</tbody>
    </table></div></div>
    <div class="mt-3">{{ $orders->links() }}</div>
</div>
@endsection
