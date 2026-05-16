@extends('layouts.app')
@section('title', __('messages.products'))
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div><h1 class="h3 mb-1">{{ __('messages.products') }}</h1><p class="text-secondary mb-0">Search, filter, wishlist, and compare products.</p></div>
        <a class="btn btn-outline-dark" href="{{ route('compare.index') }}"><i class="bi bi-columns-gap me-1"></i>Compare {{ count($activeCompare) }}</a>
    </div>
    <div class="row g-4">
        <aside class="col-lg-3">
            <form class="surface p-3 sticky-top" style="top:80px">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <strong><i class="bi bi-sliders me-1"></i>Filters</strong>
                    <span class="badge bg-light text-dark border">{{ $products->total() }} items</span>
                </div>
                <label class="form-label small text-secondary">Search</label>
                <input class="form-control mb-3" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="{{ __('messages.search') }}">
                <label class="form-label small text-secondary">Category</label>
                <select class="form-select mb-3" name="category"><option value="">All categories</option>@foreach($categories as $category)<option value="{{ $category->slug }}" @selected(($filters['category'] ?? '') === $category->slug)>{{ $category->name }}</option>@endforeach</select>
                <div class="row g-2">
                    <div class="col-6"><label class="form-label small text-secondary">Min</label><input class="form-control" name="min_price" value="{{ $filters['min_price'] ?? '' }}"></div>
                    <div class="col-6"><label class="form-label small text-secondary">Max</label><input class="form-control" name="max_price" value="{{ $filters['max_price'] ?? '' }}"></div>
                </div>
                <button class="btn btn-dark w-100 mt-3"><i class="bi bi-funnel me-1"></i>Apply filters</button>
                <a class="btn btn-link w-100 mt-2" href="{{ route('products.index') }}">Clear</a>
            </form>
        </aside>
        <section class="col-lg-9">
            <div class="row g-4">@forelse($products as $product) @include('products._card', ['product' => $product]) @empty <p>No products match this filter.</p> @endforelse</div>
            <div class="mt-4">{{ $products->links() }}</div>
        </section>
    </div>
</div>
@endsection
