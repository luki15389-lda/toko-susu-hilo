@extends('admin.layout')

@section('title', $product->exists ? 'Edit Produk' : (($fromPromo ?? false) ? 'Tambah Produk Promo' : 'Tambah Produk'))

@section('content')
    @if (!$product->exists && ($fromPromo ?? false))
        <div class="alert alert-warning py-2">
            <i class="fas fa-fire me-1"></i> Kamu sedang menambah produk untuk halaman <strong>Promo</strong> — centang "Produk Promo" sudah otomatis dicentang, tinggal isi persentase diskonnya.
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form method="POST"
                  action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}"
                  enctype="multipart/form-data">
                @csrf
                @if ($product->exists) @method('PUT') @endif

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Produk</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                        @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Kategori</label>
                        <select name="category" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat }}" @selected(old('category', $product->category) === $cat)>{{ $cat }}</option>
                            @endforeach
                        </select>
                        @error('category') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Harga (Rp)</label>
                        <input type="number" name="price" id="priceInput" class="form-control" value="{{ old('price', $product->price) }}" required min="0">
                        @error('price') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" required min="0">
                        @error('stock') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Status</label>
                        <select name="is_active" class="form-select">
                            <option value="1" @selected(old('is_active', $product->is_active ?? true))>Aktif</option>
                            <option value="0" @selected(!old('is_active', $product->is_active ?? true))>Nonaktif</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label d-block">Tampilkan di Halaman</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="isFeatured"
                                   @checked(old('is_featured', $product->is_featured ?? false))>
                            <label class="form-check-label" for="isFeatured">Produk Unggulan (Home)</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="is_promo" value="1" id="isPromo"
                                   @checked(old('is_promo', $product->is_promo ?? false))>
                            <label class="form-check-label" for="isPromo">Produk Promo</label>
                        </div>
                    </div>

                    <div class="col-md-6" id="discountWrap" style="display:none;">
                        <label class="form-label">Diskon (%)</label>
                        <div class="input-group">
                            <input type="number" name="discount_percent" id="discountInput" class="form-control"
                                   value="{{ old('discount_percent', $product->discount_percent ?? 0) }}" min="0" max="90">
                            <span class="input-group-text">%</span>
                        </div>
                        <div class="form-text">
                            Harga jadi: <span id="discountPreview" class="fw-bold text-success">—</span>
                        </div>
                        @error('discount_percent') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Gambar Produk</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        @if ($product->image)
                            <img src="{{ $product->imageUrl() }}" class="mt-2 rounded" width="80">
                        @endif
                        @error('image') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Manfaat (satu per baris)</label>
                        <textarea name="benefits" class="form-control" rows="3" placeholder="Tinggi kalsium untuk tulang kuat&#10;Rendah lemak">{{ old('benefits', $product->benefits) }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Komposisi</label>
                        <textarea name="composition" class="form-control" rows="2">{{ old('composition', $product->composition) }}</textarea>
                    </div>
                </div>

                <div class="mt-4">
                    <button class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        (function () {
            const promoCheckbox = document.getElementById('isPromo');
            const discountWrap = document.getElementById('discountWrap');
            const discountInput = document.getElementById('discountInput');
            const priceInput = document.getElementById('priceInput');
            const preview = document.getElementById('discountPreview');

            function formatRupiah(n) {
                return 'Rp ' + Math.round(n).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            function updatePreview() {
                const price = parseInt(priceInput.value || '0', 10);
                const percent = parseInt(discountInput.value || '0', 10);
                const finalPrice = Math.round(price - (price * percent / 100));
                preview.textContent = formatRupiah(finalPrice) + ' (dari ' + formatRupiah(price) + ')';
            }

            function toggleDiscount() {
                discountWrap.style.display = promoCheckbox.checked ? 'block' : 'none';
                if (promoCheckbox.checked) updatePreview();
            }

            promoCheckbox.addEventListener('change', toggleDiscount);
            discountInput.addEventListener('input', updatePreview);
            priceInput.addEventListener('input', updatePreview);

            toggleDiscount();
        })();
    </script>
@endsection
