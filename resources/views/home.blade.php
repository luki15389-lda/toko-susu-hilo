@extends('layouts.app')

@section('title', 'HiLo Store - Sehat, Aktif, dan Tetap Nikmat Bersama HiLo')

@section('content')

    {{-- 1. HERO SECTION --}}
    <div class="container">
        <div class="hero">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1>Sehat, Aktif, dan Tetap Nikmat Bersama HiLo</h1>
                    <p>Temukan berbagai pilihan susu HiLo untuk mendukung gaya hidup sehat dan aktivitasmu setiap hari.</p>
                    <div class="d-flex flex-wrap gap-2 mt-3">
                        <a href="#produk-unggulan" class="btn-hero"><i class="fas fa-shopping-bag"></i> Belanja Sekarang</a>
                        <a href="{{ route('products.index') }}" class="btn-hero-outline"><i class="fas fa-eye"></i> Lihat Produk</a>
                    </div>
                    <div class="hero-badges">
                        <span><i class="fas fa-certificate"></i> 100% Original</span>
                        <span><i class="fas fa-truck"></i> Gratis Ongkir</span>
                        <span><i class="fas fa-headset"></i> CS 24/7</span>
                    </div>
                </div>
                <div class="col-lg-6 mt-4 mt-lg-0">
                    <div class="hero-slider">
                        <img src="{{ asset('assets/images/produk1.webp') }}" class="hero-slide active" alt="Produk HiLo 1">
                        <img src="{{ asset('assets/images/produk2.webp') }}" class="hero-slide" alt="Produk HiLo 2">
                        <img src="{{ asset('assets/images/kategori1000g.webp') }}" class="hero-slide" alt="Produk HiLo 3">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. KATEGORI PRODUK --}}
    <div class="container">
        <h4 class="section-heading"><i class="fas fa-th-large"></i> Kategori Produk</h4>
        <p class="section-sub">Pilih kategori sesuai kebutuhan nutrisimu.</p>
        <div class="row g-4 mb-5 mt-1">
            @foreach ($categories as $cat)
                <div class="col-6 col-md-4 col-lg">
                    <div class="cat-card">
                        <div class="cat-img">
                            <img src="{{ $cat->imageUrl() }}" alt="{{ $cat->name }}">
                        </div>
                        <div class="cat-body">
                            <h6>{{ $cat->name }}</h6>
                            <a href="{{ route('products.index', ['category' => $cat->name]) }}" class="btn-cat">Lihat Produk</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- 3. PRODUK UNGGULAN --}}
    <div class="container" id="produk-unggulan">
        <div class="d-flex justify-content-between align-items-end flex-wrap gap-2">
            <div>
                <h4 class="section-heading mb-1"><i class="fas fa-star"></i> Produk Unggulan</h4>
                <p class="section-sub mb-0">Pilihan terbaik dan paling laris minggu ini.</p>
            </div>
            <a href="{{ route('products.index') }}" class="back-link">Lihat Semua Produk <i class="fas fa-arrow-right"></i></a>
        </div>
        <hr class="mt-2 mb-4">

        <div class="row g-3 g-md-4 mb-5">
            @forelse ($featured as $product)
                @include('products._card', ['product' => $product])
            @empty
                <div class="col-12">
                    <div class="empty-state"><i class="fas fa-box-open"></i><p>Belum ada produk.</p></div>
                </div>
            @endforelse
        </div>
    </div>

    {{-- 4. PROMO SPESIAL --}}
    <div class="container">
        <div class="promo-banner">
            <div class="row align-items-center position-relative">
                <div class="col-lg-8">
                    <h2>Promo Spesial Minggu Ini</h2>
                    <p class="mb-3 fs-5">Diskon hingga 20% untuk produk pilihan. Yuk stok susu HiLo kesayanganmu sekarang!</p>
                    <a href="{{ route('promo') }}" class="btn-promo">Lihat Semua Promo <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="col-lg-4 d-none d-lg-flex justify-content-center">
                    <i class="fas fa-tags" style="font-size: 6rem; opacity:.35;"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- 5. KEUNGGULAN TOKO --}}
    <div class="container">
        <h4 class="section-heading"><i class="fas fa-award"></i> Keunggulan Kami</h4>
        <div class="row g-4 mb-5 mt-1">
            <div class="col-6 col-md-3">
                <div class="trust-card">
                    <i class="fas fa-medal"></i>
                    <h6>Produk Berkualitas</h6>
                    <p>100% original &amp; bersertifikat</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="trust-card">
                    <i class="fas fa-tag"></i>
                    <h6>Harga Terjangkau</h6>
                    <p>Harga bersaing setiap hari</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="trust-card">
                    <i class="fas fa-shipping-fast"></i>
                    <h6>Pengiriman Cepat</h6>
                    <p>Diproses dalam 1x24 jam</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="trust-card">
                    <i class="fas fa-lock"></i>
                    <h6>Pembayaran Aman</h6>
                    <p>Transaksi terjamin &amp; nyaman</p>
                </div>
            </div>
        </div>
    </div>

    {{-- 6. TENTANG KAMI --}}
    <div class="container">
        <div class="about-section">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h4 class="section-heading"><i class="fas fa-store"></i> Tentang Kami</h4>
                    <p class="text-secondary mb-3">HiLo Store hadir untuk memudahkan kamu mendapatkan berbagai pilihan produk HiLo secara praktis dan nyaman. Kami berkomitmen menghadirkan produk original dengan pelayanan terbaik untuk mendukung gaya hidup sehat keluarga Indonesia.</p>
                    <a href="{{ route('about') }}" class="btn-hero"><i class="fas fa-info-circle"></i> Selengkapnya</a>
                </div>
                <div class="col-lg-4 text-center d-none d-lg-block">
                    <img src="{{ asset('assets/images/produk2.webp') }}" class="img-fluid" style="max-height:180px;" alt="Tentang HiLo Store">
                </div>
            </div>
        </div>
    </div>

    {{-- 9. KONTAK --}}
    <div class="container">
        <div class="contact-section">
            <h4 class="section-heading"><i class="fas fa-headset"></i> Kontak Kami</h4>
            <div class="row g-4 mt-1">
                <div class="col-md-6 col-lg-3">
                    <div class="contact-info-item">
                        <span class="icon"><i class="fas fa-map-marker-alt"></i></span>
                        <div>
                            <h6>Alamat</h6>
                            <p>Jakarta</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="contact-info-item">
                        <span class="icon"><i class="fab fa-whatsapp"></i></span>
                        <div>
                            <h6>WhatsApp</h6>
                            <p>0812-3456-7890</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="contact-info-item">
                        <span class="icon"><i class="fas fa-envelope"></i></span>
                        <div>
                            <h6>Email</h6>
                            <p>info@hilostore.com</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="contact-info-item">
                        <span class="icon"><i class="fas fa-clock"></i></span>
                        <div>
                            <h6>Jam Operasional</h6>
                            <p>Senin - Sabtu, 08.00 - 20.00</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="social-icons mt-2">
                <a href="#" class="me-2"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="me-2"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-whatsapp"></i></a>
            </div>
        </div>
    </div>

    {{-- Popup disclaimer: proyek latihan, bukan situs resmi HiLo --}}
    <div class="modal fade" id="disclaimerModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="disclaimer-icon mx-auto mb-3"><i class="fas fa-exclamation-triangle"></i></div>
                    <h5 class="fw-bold text-center mb-3">Pemberitahuan</h5>
                    <p class="text-secondary small mb-2">Website ini dibuat sebagai proyek latihan/pembelajaran dan bukan merupakan website resmi HiLo.</p>
                    <p class="text-secondary small mb-2">Nama, gambar, dan informasi terkait HiLo digunakan hanya untuk keperluan demonstrasi dan pembelajaran. Beberapa gambar produk yang digunakan bersumber dari NutriMart. Website ini tidak berafiliasi dengan atau mewakili pihak HiLo maupun NutriMart.</p>
                    <p class="text-secondary small mb-3">Website ini tidak digunakan untuk transaksi atau pembelian produk secara nyata.</p>
                    <p class="text-muted small text-center mb-4">&copy; 2026 Proyek Latihan</p>
                    <button type="button" class="btn-hero w-100 justify-content-center" data-bs-dismiss="modal">Saya Mengerti</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    (function () {
        const slides = document.querySelectorAll('.hero-slide');
        if (slides.length <= 1) return;
        let current = 0;
        setInterval(function () {
            slides[current].classList.remove('active');
            current = (current + 1) % slides.length;
            slides[current].classList.add('active');
        }, 3000);
    })();

    // ==== Popup disclaimer: muncul tiap Home dibuka/refresh & tiap kembali dari pindah tab ====
    (function () {
        const el = document.getElementById('disclaimerModal');
        if (!el) return;

        function showDisclaimer() {
            const modal = bootstrap.Modal.getInstance(el) || new bootstrap.Modal(el);
            modal.show();
        }

        showDisclaimer();

        document.addEventListener('visibilitychange', function () {
            if (document.visibilityState === 'visible') {
                showDisclaimer();
            }
        });
    })();
</script>
@endsection
