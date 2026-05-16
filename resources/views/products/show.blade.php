@extends('layouts.app')
@section('title', $product->name)
@section('content')
@php
    $categoryName = strtolower($product->category->name ?? 'general');
    $fallbackImages = [
        'electronics' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1400&q=85',
        'fashion' => 'https://images.unsplash.com/photo-1489987707025-afc232f7ea0f?auto=format&fit=crop&w=1400&q=85',
        'home' => 'https://images.unsplash.com/photo-1513161455079-7dc1de15ef3e?auto=format&fit=crop&w=1400&q=85',
        'books' => 'https://images.unsplash.com/photo-1519682337058-a94d519337bc?auto=format&fit=crop&w=1400&q=85',
        'beauty' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=1400&q=85',
        'general' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=1400&q=85',
    ];
    $imageUrl = $product->image_path ? asset('storage/'.$product->image_path) : ($fallbackImages[$categoryName] ?? $fallbackImages['general']);
@endphp
<div class="container py-5">
    <div class="row g-4">
        <div class="col-lg-6 reveal">
            <div class="surface p-2">
                <img class="img-fluid rounded-4 w-100" style="max-height:520px;object-fit:cover" src="{{ $imageUrl }}" alt="{{ $product->name }}">
            </div>
        </div>
        <div class="col-lg-6 reveal">
            <span class="badge badge-soft">{{ $product->category->name }}</span>
            <h1 class="h2 mt-3">{{ $product->name }}</h1>
            <p class="text-secondary">{{ $product->description }}</p>
            <h2 class="h4 price-pill d-inline-block">Rs. {{ number_format($product->price, 2) }}</h2>
            <p class="{{ $product->inventoryAlert() ? 'text-danger' : 'text-success' }}">{{ $product->stock_quantity }} in stock</p>
            <form class="d-flex flex-wrap gap-2" method="post" action="{{ route('cart.store', $product) }}">
                @csrf
                <input class="form-control" style="max-width:110px" type="number" name="quantity" min="1" max="{{ $product->stock_quantity }}" value="{{ old('quantity', 1) }}">
                <button class="btn btn-primary"><i class="bi bi-cart-plus me-1"></i>{{ __('messages.add_to_cart') }}</button>
                <button class="btn btn-outline-dark" formaction="{{ route('compare.store', $product) }}"><i class="bi bi-columns-gap me-1"></i>Compare</button>
            </form>
            @auth
                <form class="mt-2" method="post" action="{{ route('wishlist.store', $product) }}">@csrf<button class="btn btn-light border"><i class="bi bi-heart me-1"></i>Save to wishlist</button></form>
            @endauth
            <div class="surface p-3 mt-4">
                <h3 class="h6"><i class="bi bi-shop me-1"></i>Seller</h3>
                <p class="mb-1"><strong>{{ $product->seller->store_name }}</strong></p>
                <p class="text-secondary mb-0">{{ $product->seller->description }}</p>
                <a class="btn btn-sm btn-outline-primary mt-3" href="{{ route('stores.show', $product->seller) }}">Visit storefront</a>
            </div>
            <hr>
            <h3 class="h5"><i class="bi bi-star me-1"></i>Reviews</h3>
            @forelse($product->reviews as $review)<div class="surface p-3 mb-2"><strong class="text-warning">{{ $review->rating }}/5</strong> <span class="text-secondary">{{ $review->comment }}</span></div>@empty<p class="text-secondary">No reviews yet.</p>@endforelse
            @auth
                <form class="surface p-3 mt-3" method="post" action="{{ route('reviews.store', $product) }}">@csrf
                    <label class="form-label">Your rating</label>
                    <select class="form-select mb-2" name="rating">@for($i=5;$i>=1;$i--)<option value="{{ $i }}">{{ $i }} stars</option>@endfor</select>
                    <textarea class="form-control mb-2" name="comment" rows="3" placeholder="Share your experience">{{ old('comment') }}</textarea>
                    <button class="btn btn-dark">Publish review</button>
                </form>
            @endauth
        </div>
    </div>
</div>
@if($bundleProducts->isNotEmpty())
<section class="container pb-5">
    <div class="section-title">
        <div><h2 class="h4 m-0">Smart bundle picks</h2><p>Similar products from the same category, matched by price proximity.</p></div>
        <span class="badge badge-soft">Recommendation engine</span>
    </div>
    <div class="row g-4">
        @foreach($bundleProducts as $product)
            @include('products._card', ['product' => $product])
        @endforeach
    </div>
</section>
@endif
@if($recentlyViewed->isNotEmpty())
<section class="container pb-5">
    <div class="section-title">
        <div><h2 class="h4 m-0">Recently viewed</h2><p>Quickly jump back to products you opened earlier.</p></div>
        <a class="btn btn-sm btn-outline-primary" href="{{ route('products.index') }}">Browse more</a>
    </div>
    <div class="row g-4">
        @foreach($recentlyViewed as $product)
            @include('products._card', ['product' => $product])
        @endforeach
    </div>
</section>
@endif
@endsection
