<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="HiLo Store - Toko resmi susu HiLo berkualitas, tinggi kalsium, rendah lemak, cocok untuk keluarga sehat.">
    <title>@yield('title', 'HiLo Store - Sehat, Aktif, dan Tetap Nikmat')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="alternate icon" href="{{ asset('favicon.svg') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-shop sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <span class="icon-badge"><i class="fas fa-shopping-bag"></i></span>
                HiLo Store
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMain">
                <ul class="navbar-nav mx-auto align-items-lg-center gap-lg-1">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('promo') ? 'active' : '' }}" href="{{ route('promo') }}">Promo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Kontak</a>
                    </li>
                </ul>

                <a href="{{ route('cart.index') }}" class="btn-cart-nav {{ request()->routeIs('cart.*') ? 'active' : '' }}">
                    <span class="cart-icon-wrap">
                        <i class="fas fa-shopping-cart"></i>
                        @php($cartCount = collect(session('cart', []))->sum())
                        @if ($cartCount > 0)
                            <span class="cart-badge">{{ $cartCount }}</span>
                        @endif
                    </span>
                    <span class="d-lg-none d-inline ms-2">Keranjang</span>
                </a>
            </div>
        </div>
    </nav>

    @if (session('status'))
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show py-2" role="alert">
                <i class="fas fa-check-circle me-1"></i> {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <main class="pb-5">
        @yield('content')
    </main>

    {{-- Global toast (pengganti alert bawaan browser) --}}
    <div class="toast-container-fixed">
        <div id="globalToast" class="toast align-items-center border-0 text-white" role="alert" style="background: var(--brand-dark);">
            <div class="d-flex">
                <div class="toast-body" id="globalToastBody">Pesan</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>

    <footer class="site-footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <a href="{{ route('home') }}" class="d-inline-flex align-items-center gap-2 text-decoration-none mb-2">
                        <span class="icon-badge"><i class="fas fa-shopping-bag"></i></span>
                        <strong class="text-white fs-5">HiLo Store</strong>
                    </a>
                    <p class="small">HiLo Store hadir untuk memudahkan kamu mendapatkan berbagai pilihan produk HiLo secara praktis dan nyaman. Distributor resmi, produk 100% original.</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
                <div class="col-md-2">
                    <h6>Menu</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="{{ route('home') }}">Home</a></li>
                        <li class="mb-2"><a href="{{ route('products.index') }}">Produk</a></li>
                        <li class="mb-2"><a href="{{ route('about') }}">Tentang Kami</a></li>
                        <li class="mb-2"><a href="{{ route('promo') }}">Promo</a></li>
                        <li class="mb-2"><a href="{{ route('contact') }}">Kontak</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6>Layanan</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="{{ route('cart.index') }}">Keranjang Belanja</a></li>
                        <li class="mb-2"><a href="{{ route('contact') }}">Cara Belanja</a></li>
                        <li class="mb-2"><a href="{{ route('contact') }}">Pengiriman</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6>Hubungi Kami</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-1"></i> Jakarta</li>
                        <li class="mb-2"><i class="fas fa-phone me-1"></i> 0812-3456-7890</li>
                        <li class="mb-2"><i class="fas fa-envelope me-1"></i> info@hilostore.com</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                &copy; {{ date('Y') }} HiLo Store. Semua hak dilindungi. (Website contoh/demo)
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function stepQty(btn, dir) {
            const input = btn.parentElement.querySelector('input[type=number]');
            let val = parseInt(input.value || '1') + dir;
            const min = parseInt(input.min || '1');
            const max = parseInt(input.max || '999');
            if (val < min) val = min;
            if (val > max) val = max;
            input.value = val;
            input.dispatchEvent(new Event('change', { bubbles: true }));
        }

        function whatsappDemo() {
            showToast('Ini cuma contoh tampilan — tombol ini nantinya akan membuka WhatsApp dengan detail otomatis.');
        }

        function showToast(message) {
            const el = document.getElementById('globalToast');
            document.getElementById('globalToastBody').textContent = message;
            const toast = bootstrap.Toast.getInstance(el) || new bootstrap.Toast(el, { delay: 3500 });
            toast.show();
        }

        function updateCartBadge(count) {
            const wrap = document.querySelector('.cart-icon-wrap');
            if (!wrap) return;
            let badge = wrap.querySelector('.cart-badge');
            if (count > 0) {
                if (!badge) {
                    badge = document.createElement('span');
                    badge.className = 'cart-badge';
                    wrap.appendChild(badge);
                }
                badge.textContent = count;
            } else if (badge) {
                badge.remove();
            }
        }

        // ==== "Tambah ke Keranjang" tanpa reload halaman, di semua tempat (Home, Produk, Promo, Detail, hasil search) ====
        // Pakai event delegation supaya tetap jalan walau kartu produk baru muncul lewat AJAX search.
        document.addEventListener('submit', function (e) {
            const form = e.target;
            if (!form.classList || !form.classList.contains('add-to-cart-form')) return;

            e.preventDefault();

            const btn = form.querySelector('button[type=submit]');
            const originalHtml = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

            fetch(form.action, {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                body: new FormData(form)
            })
            .then(function (res) { return res.json(); })
            .then(function (data) {
                btn.disabled = false;
                btn.innerHTML = originalHtml;

                showToast(data.message || (data.success ? 'Produk berhasil ditambahkan ke keranjang.' : 'Gagal menambahkan produk.'));

                if (data.success && typeof data.cartCount !== 'undefined') {
                    updateCartBadge(data.cartCount);
                }
            })
            .catch(function () {
                btn.disabled = false;
                btn.innerHTML = originalHtml;
                showToast('Terjadi kesalahan, silakan coba lagi.');
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
