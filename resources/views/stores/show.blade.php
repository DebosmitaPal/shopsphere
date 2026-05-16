@extends('layouts.app')
@section('title', $seller->store_name)
@section('content')
<section class="hero-band">
    <div class="container py-5">
        <div class="row align-items-center g-4">
            <div class="col-lg-7 reveal">
                <span class="badge badge-soft mb-3"><i class="bi bi-shop me-1"></i>Verified storefront</span>
                <h1 class="display-5 fw-bold">{{ $seller->store_name }}</h1>
                <p class="lead text-secondary">{{ $seller->description }}</p>
                <div class="d-flex flex-wrap gap-2">
                    <a class="btn btn-primary" href="#store-products">Browse products</a>
                    <a class="btn btn-light border" href="mailto:{{ $seller->business_email }}">Contact seller</a>
                </div>
            </div>
            <div class="col-lg-5 reveal">
                <div class="surface p-4">
                    <h2 class="h5">Store health</h2>
                    <div class="row g-3">
                        @foreach($stats as $label => $value)
                            <div class="col-4"><div class="bg-light rounded-4 p-3 text-center"><strong data-count-to="{{ $value }}">0</strong><div class="small text-secondary text-capitalize">{{ str_replace('_', ' ', $label) }}</div></div></div>
                        @endforeach
                    </div>
                    <div class="timeline mt-4"><span class="active"></span><span class="active"></span><span class="active"></span><span></span><span></span></div>
                    <p class="small text-secondary mt-2 mb-0">Onboarding, catalog, reviews, inventory watch, fulfillment.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="store-products" class="container py-5">
    <div class="section-title">
        <div><h2 class="h4 m-0">Products from {{ $seller->store_name }}</h2><p>Seller-specific catalog view with pagination.</p></div>
        <a class="btn btn-sm btn-outline-primary" href="{{ route('products.index') }}">All marketplace products</a>
    </div>
    <div class="row g-4">
        @foreach($products as $product)
            @include('products._card', ['product' => $product])
        @endforeach
    </div>
    <div class="mt-4">{{ $products->links() }}</div>
</section>
@endsection
