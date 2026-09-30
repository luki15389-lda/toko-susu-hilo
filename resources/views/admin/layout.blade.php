<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="alternate icon" href="{{ asset('favicon.svg') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f4f6f8; }
        .sidebar { min-height: 100vh; background: #1b2a1f; color: #fff; }
        .sidebar a {
            color: #cfe8d2; text-decoration: none; display: flex; align-items: center;
            gap: .55rem; white-space: nowrap; padding: .6rem .85rem; border-radius: .375rem;
            font-size: .92rem;
        }
        .sidebar a.active, .sidebar a:hover { background: #2e7d32; color: #fff; }
        .sidebar a .badge-count { margin-left: auto; }
        .brand {
            font-weight: 700; padding: 1rem; border-bottom: 1px solid rgba(255,255,255,.1);
            display: flex; align-items: center; gap: .5rem; white-space: nowrap; font-size: 1.05rem;
        }
    </style>
</head>
<body>
<div class="d-flex">
    <div class="sidebar p-2" style="width: 250px; flex-shrink: 0;">
        <div class="brand"><i class="fas fa-shopping-bag"></i> HiLo Store</div>
        <nav class="mt-3">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
            <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') && !request('promo') ? 'active' : '' }}">
                <i class="fas fa-box"></i> Produk
            </a>
            <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="fas fa-tags"></i> Kategori
            </a>
            <a href="{{ route('admin.products.index', ['promo' => 1]) }}" class="{{ request()->routeIs('admin.products.*') && request('promo') ? 'active' : '' }}">
                <i class="fas fa-fire"></i> Promo
            </a>
            <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <i class="fas fa-receipt"></i> Order
                @php($pendingOrderCount = \App\Models\Order::where('status', 'Menunggu Konfirmasi')->count())
                @if ($pendingOrderCount > 0)
                    <span class="badge bg-danger badge-count">{{ $pendingOrderCount }}</span>
                @endif
            </a>
            <a href="{{ route('home') }}" target="_blank">
                <i class="fas fa-store"></i> Lihat Toko
            </a>
            <form method="POST" action="{{ route('admin.logout') }}" class="mt-3">
                @csrf
                <button class="btn btn-sm btn-outline-light w-100"><i class="fas fa-sign-out-alt"></i> Logout</button>
            </form>
        </nav>
    </div>

    <div class="flex-grow-1 p-4">
        <h4 class="mb-4">@yield('title', 'Dashboard')</h4>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        @yield('content')
    </div>
</div>
</body>
</html>
