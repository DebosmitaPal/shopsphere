@extends('layouts.app')
@section('content')
<div class="container-fluid"><div class="row">@include('seller.sidebar')<section class="col-md-9 col-lg-10 py-4">
<h1 class="h3">Seller orders</h1><div class="card border-0 shadow-sm"><table class="table align-middle mb-0"><thead><tr><th>Product</th><th>Customer</th><th>Qty</th><th>Status</th></tr></thead><tbody>
@foreach($items as $item)<tr><td>{{ $item->product->name }}</td><td>{{ $item->order->user->name }}</td><td>{{ $item->quantity }}</td><td><form method="post" action="{{ route('seller.orders.update', $item) }}" class="d-flex gap-2">@csrf @method('patch')<select name="status" class="form-select form-select-sm">@foreach(['packed','shipped','delivered'] as $status)<option>{{ $status }}</option>@endforeach</select><button class="btn btn-sm btn-dark">Update</button></form></td></tr>@endforeach
</tbody></table></div></section></div></div>
@endsection
