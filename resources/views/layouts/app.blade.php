<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ShopSphere')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js" defer></script>
    <style>
        :root { --ink:#111827; --muted:#667085; --line:#e5e7eb; --blue:#2563eb; --green:#0f9f6e; --amber:#f59e0b; --rose:#e11d48; --violet:#7c3aed; }
        body { background:#f4f7fb; color:var(--ink); letter-spacing:0; }
        body::before { content:""; position:fixed; inset:0; z-index:-1; background:radial-gradient(circle at 12% 8%, rgba(37,99,235,.10), transparent 28%), radial-gradient(circle at 88% 16%, rgba(15,159,110,.10), transparent 26%), linear-gradient(180deg,#f8fbff 0%,#f4f7fb 38%,#eef3f9 100%); }
        .navbar { background:rgba(255,255,255,.92)!important; backdrop-filter:blur(14px); border-bottom:1px solid rgba(229,231,235,.9); box-shadow:0 8px 30px rgba(17,24,39,.06); }
        [data-theme="dark"] body { background:#0b1220; color:#e5e7eb; }
        [data-theme="dark"] body::before { background:radial-gradient(circle at 12% 8%, rgba(37,99,235,.18), transparent 28%), radial-gradient(circle at 88% 16%, rgba(15,159,110,.14), transparent 26%), linear-gradient(180deg,#0b1220 0%,#111827 100%); }
        [data-theme="dark"] .navbar, [data-theme="dark"] .footer { background:rgba(17,24,39,.92)!important; border-color:rgba(255,255,255,.10); color:#cbd5e1; }
        [data-theme="dark"] .nav-link, [data-theme="dark"] .navbar-brand, [data-theme="dark"] .footer { color:#e5e7eb!important; }
        [data-theme="dark"] .surface, [data-theme="dark"] .metric, [data-theme="dark"] .product-card, [data-theme="dark"] .hero-panel, [data-theme="dark"] .category-tile { background:rgba(17,24,39,.94); border-color:rgba(255,255,255,.10); color:#e5e7eb; }
        [data-theme="dark"] .text-secondary { color:#94a3b8!important; }
        [data-theme="dark"] .bg-light, [data-theme="dark"] .btn-light, [data-theme="dark"] .input-group-text, [data-theme="dark"] .form-control, [data-theme="dark"] .form-select { background:#111827!important; color:#e5e7eb!important; border-color:rgba(255,255,255,.14)!important; }
        [data-theme="dark"] .price-pill { background:rgba(37,99,235,.16); color:#bfdbfe; border-color:rgba(147,197,253,.28); }
        .navbar-brand { letter-spacing:.2px; }
        .navbar-brand span { color:var(--blue); }
        .nav-search { min-width:min(500px, 42vw); }
        .nav-search .form-control, .form-control, .form-select { border-color:#dbe3ef; border-radius:.7rem; }
        .nav-search .form-control:focus, .form-control:focus, .form-select:focus { border-color:#9bbcff; box-shadow:0 0 0 .22rem rgba(37,99,235,.12); }
        .app-shell { min-height:calc(100vh - 58px); }
        .sidebar { min-height:calc(100vh - 58px); background:linear-gradient(180deg,#101827,#1e2a44); box-shadow:inset -1px 0 0 rgba(255,255,255,.05); }
        .sidebar a { color:#d8e0ee; text-decoration:none; display:flex; align-items:center; gap:.55rem; padding:.78rem 1rem; border-radius:.45rem; }
        .sidebar a:hover { background:#243252; color:#fff; }
        .metric, .surface { border:1px solid rgba(229,231,235,.92); box-shadow:0 16px 42px rgba(17,24,39,.08); border-radius:1rem; background:rgba(255,255,255,.94); }
        .metric { overflow:hidden; position:relative; }
        .metric::after { content:""; position:absolute; right:-24px; top:-28px; width:88px; height:88px; border-radius:50%; background:rgba(37,99,235,.10); }
        .metric strong { font-size:1.65rem; }
        .product-card { border:1px solid rgba(229,231,235,.92); border-radius:1rem; overflow:hidden; background:#fff; transition:transform .18s ease, box-shadow .18s ease, border-color .18s ease; }
        .product-card:hover { transform:translateY(-5px); box-shadow:0 22px 46px rgba(17,24,39,.14); border-color:#c9d7ef; }
        .product-card img { height:218px; object-fit:cover; background:#e7ebf2; transition:transform .35s ease; }
        .product-card:hover img { transform:scale(1.035); }
        .product-media { overflow:hidden; background:#dbeafe; }
        .badge-soft { background:#e8f2ff; color:#15599d; border:1px solid #cfe1ff; }
        .badge-alert { background:#fff7ed; color:#9a3412; border:1px solid #fed7aa; }
        .btn-icon { width:38px; height:38px; display:inline-flex; align-items:center; justify-content:center; }
        .btn { border-radius:.68rem; }
        .btn-primary { background:linear-gradient(135deg,#2563eb,#1d4ed8); border-color:#1d4ed8; box-shadow:0 10px 22px rgba(37,99,235,.24); }
        .btn-dark { background:#111827; border-color:#111827; }
        .hero-band { position:relative; overflow:hidden; background:linear-gradient(135deg,#ffffff 0%,#eaf2ff 46%,#eaf8f2 100%); border-bottom:1px solid var(--line); }
        .hero-band::after { content:""; position:absolute; right:-8%; bottom:-36%; width:44rem; height:44rem; background:radial-gradient(circle, rgba(37,99,235,.13), transparent 62%); pointer-events:none; }
        .hero-panel { position:relative; background:rgba(255,255,255,.94); border:1px solid rgba(255,255,255,.72); border-radius:1.15rem; box-shadow:0 24px 58px rgba(17,24,39,.14); overflow:hidden; }
        .hero-visual { min-height:360px; background:linear-gradient(180deg,rgba(17,24,39,.10),rgba(17,24,39,.46)), url('https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?auto=format&fit=crop&w=1300&q=85') center/cover; border-radius:1.15rem; }
        .hero-float { position:absolute; left:1rem; right:1rem; bottom:1rem; border-radius:1rem; background:rgba(255,255,255,.92); backdrop-filter:blur(12px); border:1px solid rgba(255,255,255,.8); }
        .category-tile { border:1px solid var(--line); background:#fff; border-radius:.9rem; transition:background .16s ease, transform .16s ease, box-shadow .16s ease; }
        .category-tile:hover { background:#f8fbff; transform:translateY(-2px); box-shadow:0 10px 24px rgba(17,24,39,.08); }
        .feature-card { position:relative; overflow:hidden; }
        .feature-card::before { content:""; position:absolute; inset:0 0 auto 0; height:4px; background:linear-gradient(90deg,#2563eb,#0f9f6e,#f59e0b); }
        .timeline { display:grid; grid-template-columns:repeat(5, 1fr); gap:.5rem; }
        .timeline span { height:.5rem; border-radius:999px; background:#dce3ee; }
        .timeline span.active { background:var(--green); }
        .section-title { display:flex; align-items:end; justify-content:space-between; gap:1rem; margin-bottom:1rem; }
        .section-title p { margin:0; color:var(--muted); }
        .price-pill { background:#eff6ff; color:#1d4ed8; border:1px solid #bfdbfe; border-radius:999px; padding:.34rem .62rem; }
        .footer { border-top:1px solid var(--line); background:rgba(255,255,255,.9); color:var(--muted); }
        .reveal { opacity:0; transform:translateY(18px); transition:opacity .55s ease, transform .55s ease; }
        .reveal.is-visible { opacity:1; transform:none; }
        .pulse-soft { animation:pulseSoft 2.6s ease-in-out infinite; }
        .floaty { animation:floaty 5.2s ease-in-out infinite; }
        .deal-strip { position:relative; overflow:hidden; border-radius:1.2rem; color:#fff; background:linear-gradient(135deg,#111827,#1d4ed8 48%,#0f9f6e); }
        .deal-strip::after { content:""; position:absolute; inset:auto -10% -55% auto; width:28rem; height:28rem; border-radius:50%; background:rgba(255,255,255,.12); }
        .countdown-box { min-width:4.2rem; border-radius:.85rem; background:rgba(255,255,255,.16); border:1px solid rgba(255,255,255,.22); backdrop-filter:blur(10px); text-align:center; padding:.7rem .5rem; }
        .floating-action { position:fixed; right:1.25rem; bottom:1.25rem; z-index:1030; box-shadow:0 18px 40px rgba(37,99,235,.28); }
        .command-overlay { position:fixed; inset:0; z-index:1060; display:none; align-items:flex-start; justify-content:center; padding-top:10vh; background:rgba(15,23,42,.44); backdrop-filter:blur(8px); }
        .command-overlay.is-open { display:flex; }
        .command-panel { width:min(680px, calc(100vw - 2rem)); border-radius:1.1rem; background:#fff; box-shadow:0 30px 80px rgba(15,23,42,.32); overflow:hidden; }
        [data-theme="dark"] .command-panel { background:#111827; color:#e5e7eb; border:1px solid rgba(255,255,255,.12); }
        .command-link { display:flex; align-items:center; gap:.75rem; padding:.85rem 1rem; color:inherit; text-decoration:none; border-top:1px solid rgba(148,163,184,.18); }
        .command-link:hover { background:#eff6ff; }
        [data-theme="dark"] .command-link:hover { background:#1f2937; }
        @keyframes pulseSoft { 0%,100%{ box-shadow:0 0 0 0 rgba(37,99,235,.22);} 50%{ box-shadow:0 0 0 12px rgba(37,99,235,0);} }
        @keyframes floaty { 0%,100%{ transform:translateY(0);} 50%{ transform:translateY(-10px);} }
        @media (max-width: 991.98px) { .nav-search { min-width:100%; } .hero-visual { min-height:280px; } }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-white sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}"><i class="bi bi-bag-check-fill me-1 text-primary"></i>Shop<span>Sphere</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav"><span class="navbar-toggler-icon"></span></button>
        <div id="nav" class="collapse navbar-collapse">
            <form class="d-flex ms-lg-4 my-2 my-lg-0 nav-search" action="{{ route('products.index') }}">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                    <input name="search" value="{{ request('search') }}" class="form-control border-start-0" placeholder="{{ __('messages.search') }}">
                </div>
            </form>
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}"><i class="bi bi-grid me-1"></i>{{ __('messages.products') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('compare.index') }}"><i class="bi bi-columns-gap me-1"></i>Compare <span class="badge text-bg-light">{{ count(session('compare', [])) }}</span></a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('cart.index') }}"><i class="bi bi-cart3 me-1"></i>{{ __('messages.cart') }}</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">{{ strtoupper(app()->getLocale()) }}</a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="{{ route('language.switch', 'en') }}">English</a>
                        <a class="dropdown-item" href="{{ route('language.switch', 'hi') }}">Hindi</a>
                    </div>
                </li>
                <li class="nav-item"><button id="themeToggle" class="btn btn-sm btn-light border" type="button" title="Toggle theme"><i class="bi bi-moon-stars"></i></button></li>
                <li class="nav-item"><button id="commandOpen" class="btn btn-sm btn-light border" type="button" title="Open command menu"><i class="bi bi-command"></i></button></li>
                @auth
                    @if(auth()->user()->role === 'admin')<li><a class="btn btn-sm btn-outline-dark" href="{{ route('admin.dashboard') }}">Admin</a></li>@endif
                    @if(auth()->user()->role === 'seller')<li><a class="btn btn-sm btn-outline-dark" href="{{ route('seller.dashboard') }}">Seller</a></li>@endif
                    <li><a class="nav-link" href="{{ route('wishlist.index') }}"><i class="bi bi-heart me-1"></i>Wishlist</a></li>
                    <li><a class="nav-link" href="{{ route('orders.index') }}"><i class="bi bi-receipt me-1"></i>{{ __('messages.orders') }}</a></li>
                    <li><a class="nav-link" href="{{ route('profile.edit') }}"><i class="bi bi-person me-1"></i>Profile</a></li>
                    <li>
                        <form method="post" action="{{ route('logout') }}">@csrf<button class="btn btn-sm btn-dark">{{ __('messages.logout') }}</button></form>
                    </li>
                @else
                    <li><a class="nav-link" href="{{ route('login') }}">{{ __('messages.login') }}</a></li>
                    <li><a class="btn btn-sm btn-primary" href="{{ route('register') }}">{{ __('messages.register') }}</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
<main>
    @if(session('success'))<div class="container mt-3"><div class="alert alert-success">{{ session('success') }}</div></div>@endif
    @if($errors->any())<div class="container mt-3"><div class="alert alert-danger">{{ $errors->first() }}</div></div>@endif
    @yield('content')
</main>
<a class="btn btn-primary rounded-pill floating-action pulse-soft" href="{{ route('cart.index') }}"><i class="bi bi-cart3 me-1"></i>Cart</a>
<div id="commandPalette" class="command-overlay" aria-hidden="true">
    <div class="command-panel">
        <div class="p-3 border-bottom">
            <form action="{{ route('products.index') }}">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                    <input id="commandSearch" class="form-control border-start-0" name="search" placeholder="Search marketplace">
                    <button class="btn btn-primary">Search</button>
                </div>
            </form>
        </div>
        <a class="command-link" href="{{ route('products.index') }}"><i class="bi bi-grid text-primary"></i><span>Browse products</span></a>
        <a class="command-link" href="{{ route('compare.index') }}"><i class="bi bi-columns-gap text-success"></i><span>Compare products</span></a>
        <a class="command-link" href="{{ route('cart.index') }}"><i class="bi bi-cart3 text-warning"></i><span>Open cart</span></a>
        <a class="command-link" href="{{ route('seller.register') }}"><i class="bi bi-shop text-info"></i><span>Start seller onboarding</span></a>
        @auth
            <a class="command-link" href="{{ route('orders.index') }}"><i class="bi bi-receipt text-danger"></i><span>Track orders</span></a>
        @else
            <a class="command-link" href="{{ route('login') }}"><i class="bi bi-person text-danger"></i><span>Login</span></a>
        @endauth
    </div>
</div>
<footer class="footer py-4 mt-5">
    <div class="container d-flex flex-column flex-md-row justify-content-between gap-2">
        <span>ShopSphere marketplace management system</span>
        <span>Admin monitoring - Seller operations - Customer commerce</span>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    (() => {
        const root = document.documentElement;
        const savedTheme = localStorage.getItem('shopsphere-theme');
        if (savedTheme) root.dataset.theme = savedTheme;

        document.getElementById('themeToggle')?.addEventListener('click', () => {
            root.dataset.theme = root.dataset.theme === 'dark' ? 'light' : 'dark';
            localStorage.setItem('shopsphere-theme', root.dataset.theme);
        });

        const palette = document.getElementById('commandPalette');
        const search = document.getElementById('commandSearch');
        const openPalette = () => {
            palette?.classList.add('is-open');
            palette?.setAttribute('aria-hidden', 'false');
            setTimeout(() => search?.focus(), 30);
        };
        const closePalette = () => {
            palette?.classList.remove('is-open');
            palette?.setAttribute('aria-hidden', 'true');
        };
        document.getElementById('commandOpen')?.addEventListener('click', openPalette);
        palette?.addEventListener('click', (event) => {
            if (event.target === palette) closePalette();
        });
        document.addEventListener('keydown', (event) => {
            if ((event.ctrlKey || event.metaKey) && event.key.toLowerCase() === 'k') {
                event.preventDefault();
                openPalette();
            }
            if (event.key === 'Escape') closePalette();
        });

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12 });
        document.querySelectorAll('.reveal').forEach((item) => observer.observe(item));

        document.querySelectorAll('[data-count-to]').forEach((item) => {
            const target = Number(item.dataset.countTo || 0);
            const start = performance.now();
            const tick = (now) => {
                const progress = Math.min((now - start) / 900, 1);
                item.textContent = Math.round(target * progress).toLocaleString();
                if (progress < 1) requestAnimationFrame(tick);
            };
            requestAnimationFrame(tick);
        });

        const countdown = document.querySelector('[data-countdown]');
        if (countdown) {
            const end = Date.now() + 1000 * 60 * 60 * 8;
            const update = () => {
                const remaining = Math.max(0, end - Date.now());
                const hours = Math.floor(remaining / 3600000);
                const minutes = Math.floor((remaining % 3600000) / 60000);
                const seconds = Math.floor((remaining % 60000) / 1000);
                countdown.querySelector('[data-hours]').textContent = String(hours).padStart(2, '0');
                countdown.querySelector('[data-minutes]').textContent = String(minutes).padStart(2, '0');
                countdown.querySelector('[data-seconds]').textContent = String(seconds).padStart(2, '0');
            };
            update();
            setInterval(update, 1000);
        }
    })();
</script>
@stack('scripts')
</body>
</html>
