<div class="col-sm-6 col-lg-3 reveal">
    @php
        $categoryName = strtolower($product->category->name ?? 'general');
        $fallbackImages = [
            'electronics' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=900&q=85',
            'fashion' => 'https://images.unsplash.com/photo-1489987707025-afc232f7ea0f?auto=format&fit=crop&w=900&q=85',
            'home' => 'https://images.unsplash.com/photo-1513161455079-7dc1de15ef3e?auto=format&fit=crop&w=900&q=85',
            'books' => 'https://images.unsplash.com/photo-1519682337058-a94d519337bc?auto=format&fit=crop&w=900&q=85',
            'beauty' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=900&q=85',
            'general' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=900&q=85',
        ];
        $imageUrl = $product->image_path ? asset('storage/'.$product->image_path) : ($fallbackImages[$categoryName] ?? $fallbackImages['general']);
    @endphp
    <div class="card product-card h-100">
        <div class="position-relative product-media">
            <img src="{{ $imageUrl }}" class="card-img-top" alt="{{ $product->name }}">
            @if($product->inventoryAlert())<span class="badge badge-alert position-absolute top-0 start-0 m-2">Low stock</span>@endif
            <form method="post" action="{{ route('compare.store', $product) }}" class="position-absolute top-0 end-0 m-2">
                @csrf
                <button class="btn btn-sm btn-light shadow-sm" title="Compare"><i class="bi bi-columns-gap me-1"></i>Compare</button>
            </form>
        </div>
        <div class="card-body d-flex flex-column">
            <div class="d-flex justify-content-between gap-2">
                <span class="badge bg-light text-dark border">{{ $product->category->name ?? 'General' }}</span>
                <span class="small text-secondary"><i class="bi bi-star-fill text-warning me-1"></i>{{ $product->reviews_count ?? $product->reviews()->count() }}</span>
            </div>
            <h3 class="h6 mt-1">{{ $product->name }}</h3>
            <p class="small text-secondary flex-grow-1">{{ str($product->description)->limit(70) }}</p>
            <div class="d-flex align-items-center justify-content-between">
                <strong class="price-pill">Rs. {{ number_format($product->price, 2) }}</strong>
                <a class="btn btn-sm btn-primary" href="{{ route('products.show', $product) }}">View</a>
            </div>
            @auth
                <form method="post" action="{{ route('wishlist.store', $product) }}" class="mt-2">@csrf<button class="btn btn-sm btn-light border w-100"><i class="bi bi-heart me-1"></i>Save to wishlist</button></form>
            @endauth
        </div>
    </div>
</div>
