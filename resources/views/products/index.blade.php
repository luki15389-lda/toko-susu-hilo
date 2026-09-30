@extends('layouts.app')

@section('title', 'Semua Produk - HiLo Store')

@section('content')
<div class="container">

    <div class="row g-4">
        {{-- Sidebar kategori (desktop) --}}
        <div class="col-lg-3 d-none d-lg-block">
            <div class="sidebar-cat">
                <h6 class="sidebar-cat-title"><i class="fas fa-list-ul"></i> Kategori</h6>
                <a href="{{ route('products.index') }}" class="sidebar-cat-item {{ !request('category') ? 'active' : '' }}">
                    <span><i class="fas fa-layer-group me-2"></i>Semua Menu</span>
                    <span class="count-badge">{{ $totalAll }}</span>
                </a>
                @foreach ($categories as $cat)
                    <a href="{{ route('products.index', ['category' => $cat]) }}" class="sidebar-cat-item {{ request('category') === $cat ? 'active' : '' }}">
                        <span><i class="fas fa-tag me-2"></i>{{ $cat }}</span>
                        <span class="count-badge">{{ $categoryCounts[$cat] ?? 0 }}</span>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <div>
                    <h4 class="section-heading mb-0" id="pageHeading"><i class="fas fa-box"></i> {{ request('category') ?: 'Semua Menu' }}</h4>
                </div>
                <form method="GET" id="searchForm" class="search-box" style="max-width: 260px;" data-base-url="{{ route('products.index') }}">
                    @if (request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    <input type="text" name="q" id="searchInput" class="form-control" placeholder="Cari menu..." value="{{ request('q') }}" autocomplete="off">
                    <button type="submit" tabindex="-1"><i class="fas fa-search"></i></button>
                </form>
            </div>

            {{-- Kategori (mobile) --}}
            <div class="category-scroll mb-4 d-lg-none">
                <a href="{{ route('products.index') }}" class="category-pill {{ !request('category') ? 'active' : '' }}">
                    <span style="font-weight:600;">Semua ({{ $totalAll }})</span>
                </a>
                @foreach ($categories as $cat)
                    <a href="{{ route('products.index', ['category' => $cat]) }}" class="category-pill {{ request('category') === $cat ? 'active' : '' }}">
                        <span>{{ $cat }} ({{ $categoryCounts[$cat] ?? 0 }})</span>
                    </a>
                @endforeach
            </div>

            <div id="productGrid">
                @include('products._grid', ['products' => $products])
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    (function () {
        const input = document.getElementById('searchInput');
        const form = document.getElementById('searchForm');
        const grid = document.getElementById('productGrid');
        const baseUrl = form.dataset.baseUrl;
        let controller;

        function buildUrl() {
            const params = new URLSearchParams(new FormData(form));
            if (!params.get('q')) params.delete('q');
            const query = params.toString();
            return baseUrl + (query ? '?' + query : '');
        }

        function runSearch() {
            const url = buildUrl();

            if (controller) controller.abort();
            controller = new AbortController();

            fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                signal: controller.signal
            })
            .then(function (res) { return res.text(); })
            .then(function (html) {
                grid.innerHTML = html;
                window.history.replaceState({}, '', url);
            })
            .catch(function (err) {
                // abaikan AbortError (request lama dibatalkan karena ada ketikan baru)
            });
        }

        input.addEventListener('input', function () {
            runSearch();
        });

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            runSearch();
        });
    })();
</script>
@endsection
