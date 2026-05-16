@extends('layouts.app')
@section('title', 'ShopSphere')
@section('content')
<section class="hero-band">
    <div class="container py-5 position-relative">
        <div class="row align-items-center g-4">
            <div class="col-lg-7 reveal">
                <span class="badge badge-soft mb-3"><i class="bi bi-stars me-1"></i>{{ __('messages.marketplace') }}</span>
                <h1 class="display-4 fw-bold mb-3">ShopSphere</h1>
                <p class="lead text-secondary mb-4">{{ __('messages.hero_copy') }}</p>
                <div class="d-flex flex-wrap gap-2">
                    <a class="btn btn-primary btn-lg" href="{{ route('products.index') }}"><i class="bi bi-bag me-1"></i>{{ __('messages.shop_now') }}</a>
                    <a class="btn btn-outline-dark btn-lg" href="{{ route('seller.register') }}"><i class="bi bi-shop me-1"></i>{{ __('messages.become_seller') }}</a>
                    <a class="btn btn-light border btn-lg" href="{{ route('compare.index') }}"><i class="bi bi-columns-gap me-1"></i>Compare</a>
                </div>
                <div class="row g-3 mt-4">
                    @foreach($stats as $label => $value)
                        <div class="col-6 col-md-3"><div class="surface p-3"><div class="small text-secondary text-capitalize">{{ $label }}</div><strong data-count-to="{{ $value }}">0</strong></div></div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-5 reveal">
                <div class="hero-panel hero-visual floaty">
                    <div class="hero-float p-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div><strong>Marketplace pulse</strong><div class="small text-secondary">Seller, inventory, and order overview</div></div>
                            <span class="badge text-bg-success">Live</span>
                        </div>
                        <div class="row g-2">
                            @foreach($categories->take(4) as $category)
                                <div class="col-6"><a class="category-tile d-block text-decoration-none text-dark p-3 h-100" href="{{ route('products.index', ['category' => $category->slug]) }}"><strong>{{ $category->name }}</strong><div class="text-secondary small">{{ $category->products_count }} items</div></a></div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="container py-5">
    <div class="row g-4">
        <div class="col-md-4 reveal"><div class="surface feature-card p-4 h-100"><span class="badge text-bg-primary mb-3"><i class="bi bi-speedometer2 me-1"></i>Admin</span><h2 class="h5">Central monitoring</h2><p class="text-secondary mb-0">Seller approvals, category control, payments, order status, and inventory alerts in one dashboard.</p></div></div>
        <div class="col-md-4 reveal"><div class="surface feature-card p-4 h-100"><span class="badge text-bg-success mb-3"><i class="bi bi-box-seam me-1"></i>Seller</span><h2 class="h5">Inventory workflow</h2><p class="text-secondary mb-0">Product CRUD, image uploads, low-stock signals, order queues, and sales analytics.</p></div></div>
        <div class="col-md-4 reveal"><div class="surface feature-card p-4 h-100"><span class="badge text-bg-warning mb-3"><i class="bi bi-person-check me-1"></i>Customer</span><h2 class="h5">Shopping tools</h2><p class="text-secondary mb-0">Search, filters, cart sessions, wishlists, comparisons, checkout, tracking, and reviews.</p></div></div>
    </div>
</section>
<section class="container pb-5">
    <div class="deal-strip p-4 p-lg-5 reveal">
        <div class="row align-items-center g-4 position-relative">
            <div class="col-lg-7">
                <span class="badge bg-light text-dark mb-3"><i class="bi bi-lightning-charge-fill text-warning me-1"></i>Deal room</span>
                <h2 class="h3 fw-bold">Fast-moving products with limited stock signals</h2>
                <p class="mb-0 opacity-75">A showcase section for promotions, urgency, and inventory-aware merchandising.</p>
            </div>
            <div class="col-lg-5">
                <div class="d-flex gap-2 justify-content-lg-end" data-countdown>
                    <div class="countdown-box"><strong class="d-block fs-4" data-hours>08</strong><span class="small">Hours</span></div>
                    <div class="countdown-box"><strong class="d-block fs-4" data-minutes>00</strong><span class="small">Mins</span></div>
                    <div class="countdown-box"><strong class="d-block fs-4" data-seconds>00</strong><span class="small">Secs</span></div>
                </div>
            </div>
        </div>
        <div class="row g-3 mt-3 position-relative">
            @foreach($dealProducts as $product)
                <div class="col-md-4">
                    <a class="d-block text-decoration-none text-dark bg-white rounded-4 p-3 h-100" href="{{ route('products.show', $product) }}">
                        <span class="badge badge-soft mb-2">{{ $product->category->name }}</span>
                        <h3 class="h6">{{ $product->name }}</h3>
                        <strong>Rs. {{ number_format($product->price, 2) }}</strong>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
<section class="container py-5">
    <div class="section-title">
        <div><h2 class="h4 m-0">{{ __('messages.featured') }}</h2><p>Popular catalog items across verified vendors</p></div>
        <a class="btn btn-sm btn-outline-primary" href="{{ route('products.index') }}">{{ __('messages.view_all') }}</a>
    </div>
    <div class="row g-4">
        @foreach($featuredProducts as $product)
            @include('products._card', ['product' => $product])
        @endforeach
    </div>
</section>
<section class="container pb-5">
    <div class="section-title">
        <div><h2 class="h4 m-0">Low stock picks</h2><p>Items that showcase inventory alerts and seller operations</p></div>
        <span class="badge badge-alert">Inventory watch</span>
    </div>
    <div class="row g-4">
        @foreach($latestProducts as $product)
            @include('products._card', ['product' => $product])
        @endforeach
    </div>
</section>
@endsection
