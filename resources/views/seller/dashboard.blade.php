@extends('layouts.app')
@section('title', 'Seller dashboard')
@section('content')
<div class="container-fluid"><div class="row">@include('seller.sidebar')<section class="col-md-9 col-lg-10 py-4">
<h1 class="h3">{{ $seller->store_name }}</h1>
@if($seller->status !== 'approved')<div class="alert alert-warning">Your seller account is {{ $seller->status }}. Admin approval is required before full selling.</div>@endif
<div class="row g-3 mb-4">@foreach($stats as $label => $value)<div class="col-md-3"><div class="card metric"><div class="card-body"><div class="text-secondary text-capitalize">{{ str_replace('_',' ', $label) }}</div><strong class="h4">{{ number_format($value) }}</strong></div></div></div>@endforeach</div>
<div class="card border-0 shadow-sm"><div class="card-body"><h2 class="h5">Low inventory</h2>@foreach($lowStockProducts as $product)<div class="d-flex justify-content-between border-bottom py-2"><span>{{ $product->name }}</span><span class="text-danger">{{ $product->stock_quantity }}</span></div>@endforeach</div></div>
</section></div></div>
@endsection
