@extends('layouts.app')
@section('title', 'Compare products')
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div><h1 class="h3 mb-1">Compare products</h1><p class="text-secondary mb-0">Compare up to four products by price, stock, category, and seller.</p></div>
        @if($products->isNotEmpty())<form method="post" action="{{ route('compare.clear') }}">@csrf @method('delete')<button class="btn btn-outline-danger">Clear</button></form>@endif
    </div>
    @if($products->isEmpty())
        <div class="surface p-5 text-center"><p class="text-secondary">No products selected for comparison.</p><a class="btn btn-primary" href="{{ route('products.index') }}">Browse products</a></div>
    @else
        <div class="surface table-responsive">
            <table class="table align-middle mb-0">
                <thead><tr><th>Feature</th>@foreach($products as $product)<th>{{ $product->name }}</th>@endforeach</tr></thead>
                <tbody>
                    <tr><th>Price</th>@foreach($products as $product)<td>Rs. {{ number_format($product->price, 2) }}</td>@endforeach</tr>
                    <tr><th>Category</th>@foreach($products as $product)<td>{{ $product->category->name }}</td>@endforeach</tr>
                    <tr><th>Seller</th>@foreach($products as $product)<td>{{ $product->seller->store_name }}</td>@endforeach</tr>
                    <tr><th>Stock</th>@foreach($products as $product)<td class="{{ $product->inventoryAlert() ? 'text-danger' : 'text-success' }}">{{ $product->stock_quantity }}</td>@endforeach</tr>
                    <tr><th>Action</th>@foreach($products as $product)<td><a class="btn btn-sm btn-primary" href="{{ route('products.show', $product) }}">View</a><form class="d-inline" method="post" action="{{ route('compare.destroy', $product) }}">@csrf @method('delete')<button class="btn btn-sm btn-light border">Remove</button></form></td>@endforeach</tr>
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
