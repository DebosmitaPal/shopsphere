@extends('layouts.app')
@section('content')
<div class="container-fluid"><div class="row">@include('seller.sidebar')<section class="col-md-9 col-lg-10 py-4">
<div class="d-flex justify-content-between align-items-center mb-3"><h1 class="h3">Products</h1><a class="btn btn-primary" href="{{ route('seller.products.create') }}">Add product</a></div>
<div class="card border-0 shadow-sm"><table class="table align-middle mb-0"><thead><tr><th>Name</th><th>Category</th><th>Price</th><th>Stock</th><th></th></tr></thead><tbody>
@foreach($products as $product)<tr><td>{{ $product->name }}</td><td>{{ $product->category->name }}</td><td>Rs. {{ $product->price }}</td><td class="{{ $product->inventoryAlert() ? 'text-danger' : '' }}">{{ $product->stock_quantity }}</td><td class="text-end"><a class="btn btn-sm btn-outline-dark" href="{{ route('seller.products.edit', $product) }}">Edit</a><form class="d-inline" method="post" action="{{ route('seller.products.destroy', $product) }}">@csrf @method('delete')<button class="btn btn-sm btn-outline-danger">Delete</button></form></td></tr>@endforeach
</tbody></table></div><div class="mt-3">{{ $products->links() }}</div></section></div></div>
@endsection
