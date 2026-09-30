@php
    $wrapClass = $wrapClass ?? 'col-6 col-md-4 col-lg-3';
@endphp
<div class="{{ $wrapClass }}">
    <div class="product-card">
        <a href="{{ route('products.show', $product->slug) }}" class="img-wrap">
            <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" loading="lazy">
            @if ($product->hasDiscount())
                <span class="discount-badge">Diskon {{ $product->discount_percent }}%</span>
            @endif
            @if ($product->stock == 0)
                <span class="stock-tag out">Habis</span>
            @elseif ($product->stock <= 10)
                <span class="stock-tag low">Sisa {{ $product->stock }}</span>
            @else
                <span class="stock-tag ok">Tersedia</span>
            @endif
        </a>
        <div class="card-body">
            <span class="p-cat">{{ $product->category }}</span>
            <a href="{{ route('products.show', $product->slug) }}" class="p-name text-decoration-none text-dark">{{ $product->name }}</a>
            @if ($product->hasDiscount())
                <div class="p-price-old">{{ $product->formattedPrice() }}</div>
                <div class="p-price text-danger">{{ $product->formattedDiscountedPrice() }}</div>
            @else
                <div class="p-price">{{ $product->formattedPrice() }}</div>
            @endif

            <form action="{{ route('cart.add', $product) }}" method="POST" class="card-actions-stack add-to-cart-form">
                @csrf
                <div class="qty-stepper qty-stepper-full">
                    <button type="button" onclick="stepQty(this,-1)">-</button>
                    <input type="number" name="qty" value="1" min="1" max="{{ max($product->stock,1) }}">
                    <button type="button" onclick="stepQty(this,1)">+</button>
                </div>
                <button type="submit" class="btn-add-cart-cta" {{ $product->stock == 0 ? 'disabled' : '' }}>
                    <i class="fas fa-cart-plus"></i> {{ $product->stock == 0 ? 'Stok Habis' : 'Tambah Keranjang' }}
                </button>
            </form>

            <a href="{{ route('products.show', $product->slug) }}" class="btn-detail-cta">Lihat Detail</a>
        </div>
    </div>
</div>
