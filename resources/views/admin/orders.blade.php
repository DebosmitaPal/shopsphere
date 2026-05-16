@extends('layouts.app')
@section('content')
<div class="container-fluid"><div class="row">@include('admin.sidebar')<section class="col-md-9 col-lg-10 py-4">
<h1 class="h3">Monitor orders</h1><div class="card border-0 shadow-sm"><table class="table align-middle mb-0"><thead><tr><th>Order</th><th>Customer</th><th>Total</th><th>Status</th></tr></thead><tbody>
@foreach($orders as $order)<tr><td>{{ $order->order_number }}</td><td>{{ $order->user->name }}</td><td>Rs. {{ $order->total }}</td><td><form method="post" action="{{ route('admin.orders.update', $order) }}" class="d-flex gap-2">@csrf @method('patch')<select class="form-select form-select-sm" name="status">@foreach(['pending','confirmed','packed','shipped','delivered','cancelled'] as $status)<option @selected($order->status===$status)>{{ $status }}</option>@endforeach</select><button class="btn btn-sm btn-dark">Save</button></form></td></tr>@endforeach
</tbody></table></div></section></div></div>
@endsection
