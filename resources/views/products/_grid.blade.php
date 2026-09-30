<p class="section-sub mb-3">{{ $products->total() }} produk tersedia</p>

<div class="row g-3 g-md-4">
    @forelse ($products as $product)
        @include('products._card', ['product' => $product])
    @empty
        <div class="col-12">
            <div class="empty-state">
                <i class="fas fa-box-open"></i>
                <p>Belum ada produk yang cocok.</p>
            </div>
        </div>
    @endforelse
</div>

<div class="mt-4">
    {{ $products->links() }}
</div>
