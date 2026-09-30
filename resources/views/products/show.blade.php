@extends('layouts.app')

@section('title', $product->name . ' - HiLo Store')

@section('content')
<div class="container">
    <button type="button" onclick="history.length > 1 ? history.back() : window.location='{{ route('products.index') }}'" class="back-link btn btn-link p-0 mb-3">
        <i class="fas fa-arrow-left"></i> Kembali
    </button>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="detail-img-wrap">
                <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}">
            </div>
        </div>
        <div class="col-lg-7">
            <span class="cat-tag" style="position:static;display:inline-block;">{{ $product->category }}</span>
            <h1 class="h3 mt-2">{{ $product->name }}</h1>

            <div class="text-warning mb-2">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                <span class="text-muted small ms-1">(4.5/5 &middot; 128 ulasan)</span>
            </div>

            @if ($product->hasDiscount())
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="text-muted text-decoration-line-through">{{ $product->formattedPrice() }}</span>
                    <span class="badge bg-danger">-{{ $product->discount_percent }}%</span>
                </div>
                <div class="p-price mb-2 text-danger" style="font-size:1.6rem;">{{ $product->formattedDiscountedPrice() }}</div>
            @else
                <div class="p-price mb-2" style="font-size:1.6rem;">{{ $product->formattedPrice() }}</div>
            @endif

            @if ($product->stock == 0)
                <span class="stock-tag out" style="position:static;display:inline-block;">Stok Habis</span>
            @elseif ($product->stock <= 10)
                <span class="stock-tag low" style="position:static;display:inline-block;">Stok Terbatas ({{ $product->stock }} tersisa)</span>
            @else
                <span class="stock-tag ok" style="position:static;display:inline-block;">Stok Tersedia ({{ $product->stock }})</span>
            @endif

            <hr>

            <h6>Deskripsi Produk</h6>
            <p style="white-space:pre-line;" class="text-secondary">{{ $product->description }}</p>

            @if ($product->benefitsList())
                <h6>Manfaat Utama</h6>
                <ul class="text-secondary">
                    @foreach ($product->benefitsList() as $benefit)
                        <li>{{ $benefit }}</li>
                    @endforeach
                </ul>
            @endif

            @if ($product->composition)
                <h6>Komposisi</h6>
                <p class="text-secondary">{{ $product->composition }}</p>
            @endif

            <form action="{{ route('cart.add', $product) }}" method="POST" class="d-flex align-items-center gap-3 flex-wrap mt-3 add-to-cart-form">
                @csrf
                <div class="qty-stepper">
                    <button type="button" onclick="stepQty(this,-1)">-</button>
                    <input type="number" name="qty" value="1" min="1" max="{{ max($product->stock,1) }}">
                    <button type="button" onclick="stepQty(this,1)">+</button>
                </div>
                <button type="submit" class="btn-add-cart" style="flex-grow:0;padding:.6rem 1.4rem;" {{ $product->stock == 0 ? 'disabled' : '' }}>
                    <i class="fas fa-cart-plus"></i> {{ $product->stock == 0 ? 'Stok Habis' : 'Tambah ke Keranjang' }}
                </button>
                <button type="button" class="btn btn-outline-success" onclick="whatsappDemo()">
                    <i class="fab fa-whatsapp"></i> Tanya via WhatsApp
                </button>
            </form>

            <div class="row g-3 mt-4">
                <div class="col-md-4">
                    <div class="trust-card py-3"><i class="fas fa-shield-alt"></i><h6 class="small mb-0">Jaminan Original</h6></div>
                </div>
                <div class="col-md-4">
                    <div class="trust-card py-3"><i class="fas fa-truck"></i><h6 class="small mb-0">Gratis Ongkir</h6></div>
                </div>
                <div class="col-md-4">
                    <div class="trust-card py-3"><i class="fas fa-undo-alt"></i><h6 class="small mb-0">7 Hari Retur</h6></div>
                </div>
            </div>
        </div>
    </div>

    @if ($related->count())
        <h5 class="section-heading mt-5"><i class="fas fa-layer-group"></i> Produk Terkait</h5>
        <div class="row g-4">
            @foreach ($related as $r)
                @include('products._card', ['product' => $r])
            @endforeach
        </div>
    @endif
</div>
@endsection
