@extends('layouts.app')
@section('title', 'Admin dashboard')
@section('content')
<div class="container-fluid"><div class="row">
    @include('admin.sidebar')
    <section class="col-md-9 col-lg-10 py-4">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
            <div>
                <span class="badge badge-soft mb-2"><i class="bi bi-command me-1"></i>Operations center</span>
                <h1 class="h3 mb-1">Admin dashboard</h1>
                <p class="text-secondary mb-0">Monitor marketplace health, inventory risk, and order movement.</p>
            </div>
            <a class="btn btn-primary" href="{{ route('admin.orders.index') }}"><i class="bi bi-receipt me-1"></i>Review orders</a>
        </div>
        <div class="row g-3 mb-4">
            @foreach($stats as $label => $value)
                @php($icons = ['revenue' => 'bi-currency-rupee', 'orders' => 'bi-bag-check', 'sellers' => 'bi-shop', 'customers' => 'bi-people'])
                <div class="col-md-3">
                    <div class="card metric h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="text-secondary text-capitalize">{{ str_replace('_',' ', $label) }}</div>
                                    <strong class="h4">{{ is_numeric($value) ? number_format($value) : $value }}</strong>
                                </div>
                                <span class="btn btn-sm btn-light border rounded-circle"><i class="bi {{ $icons[$label] ?? 'bi-graph-up' }}"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row g-4">
            <div class="col-lg-7"><div class="surface p-4"><div class="d-flex justify-content-between mb-3"><h2 class="h5 mb-0">Marketplace analytics</h2><span class="badge bg-light text-dark border">Live snapshot</span></div><canvas id="salesChart" height="120"></canvas></div></div>
            <div class="col-lg-5"><div class="surface p-4"><h2 class="h5">Inventory alerts</h2>@forelse($lowStockProducts as $product)<div class="d-flex justify-content-between align-items-center border-bottom py-2"><span>{{ $product->name }}</span><span class="badge badge-alert">{{ $product->stock_quantity }} left</span></div>@empty<p class="text-secondary mb-0">No low-stock products.</p>@endforelse</div></div>
        </div>
    </section>
</div></div>
@push('scripts')<script>document.addEventListener('DOMContentLoaded',()=>new Chart(document.getElementById('salesChart'),{type:'bar',data:{labels:['Revenue','Orders','Sellers','Customers'],datasets:[{label:'Analytics',data:[{{ $stats['revenue'] }},{{ $stats['orders'] }},{{ $stats['sellers'] }},{{ $stats['customers'] }}],borderRadius:10,backgroundColor:['#2563eb','#0f9f6e','#f59e0b','#7c3aed']}]},options:{plugins:{legend:{display:false}},scales:{y:{grid:{color:'#eef2f7'}},x:{grid:{display:false}}}}}));</script>@endpush
@endsection
