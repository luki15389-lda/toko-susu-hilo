@extends('layouts.app')

@section('title', 'Promo - HiLo Store')

@section('content')
<div class="container">
    <div class="promo-banner">
        <div class="row align-items-center position-relative">
            <div class="col-lg-8">
                <h2>Promo Spesial Minggu Ini</h2>
                <p class="mb-0 fs-5">Diskon hingga 20% untuk produk pilihan di bawah ini. Buruan sebelum kehabisan stok!</p>
            </div>
            <div class="col-lg-4 d-none d-lg-flex justify-content-center">
                <i class="fas fa-tags" style="font-size: 6rem; opacity:.35;"></i>
            </div>
        </div>
    </div>

    <h4 class="section-heading"><i class="fas fa-fire"></i> Produk Promo</h4>
    <p class="section-sub mb-4">*Label diskon di bawah ini bersifat ilustrasi untuk keperluan demo website.</p>

    <div class="row g-3 g-md-4">
        @forelse ($promoProducts as $product)
            @include('products._card', ['product' => $product])
        @empty
            <div class="col-12">
                <div class="empty-state"><i class="fas fa-box-open"></i><p>Belum ada produk promo saat ini.</p></div>
            </div>
        @endforelse
    </div>
</div>
@endsection
