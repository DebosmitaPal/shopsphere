@extends('layouts.app')
@section('title', 'Wishlist')
@section('content')
<div class="container py-4">
    <h1 class="h3 mb-3">Wishlist</h1>
    <div class="row g-4">
        @forelse($items as $item)
            <div class="col-md-4"><div class="card border-0 shadow-sm h-100"><div class="card-body"><h2 class="h5">{{ $item->product->name }}</h2><p>Rs. {{ $item->product->price }}</p><a class="btn btn-sm btn-outline-primary" href="{{ route('products.show', $item->product) }}">View</a><form class="d-inline" method="post" action="{{ route('wishlist.destroy', $item) }}">@csrf @method('delete')<button class="btn btn-sm btn-outline-danger">Remove</button></form></div></div></div>
        @empty
            <p class="text-secondary">No wishlist items yet.</p>
        @endforelse
    </div>
</div>
@endsection
