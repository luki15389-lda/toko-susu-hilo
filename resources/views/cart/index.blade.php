@extends('layouts.app')

@section('title', 'Keranjang Belanja - HiLo Store')

@section('content')
<div class="container">
    <h4 class="section-heading"><i class="fas fa-shopping-cart"></i> Keranjang Belanja</h4>

    @if (count($items) > 0)
        <div class="row g-4">
            <div class="col-lg-8">
                @foreach ($items as $item)
                    @php($product = $item['product'])
                    <div class="cart-item-card" data-product-id="{{ $product->id }}">
                        <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}">
                        <div class="flex-grow-1">
                            <a href="{{ route('products.show', $product->slug) }}" class="text-dark fw-semibold text-decoration-none cart-item-name">{{ $product->name }}</a>
                            <div class="text-muted small">{{ $product->category }}</div>
                            @if ($product->hasDiscount())
                                <div class="small text-muted text-decoration-line-through">{{ $product->formattedPrice() }}</div>
                                <div class="p-price text-danger">{{ $product->formattedDiscountedPrice() }}</div>
                            @else
                                <div class="p-price">{{ $product->formattedPrice() }}</div>
                            @endif
                        </div>

                        <form action="{{ route('cart.update', $product) }}" method="POST" class="qty-stepper cart-qty-form" data-product-id="{{ $product->id }}" onchange="this.requestSubmit()">
                            @csrf
                            <button type="button" onclick="stepQty(this,-1)">-</button>
                            <input type="number" name="qty" value="{{ $item['qty'] }}" min="1" max="{{ max($product->stock,1) }}">
                            <button type="button" onclick="stepQty(this,1)">+</button>
                        </form>

                        <div class="text-end" style="min-width:110px;">
                            <div class="fw-bold item-subtotal">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</div>
                        </div>

                        <form action="{{ route('cart.remove', $product) }}" method="POST" class="cart-remove-form" data-product-id="{{ $product->id }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                @endforeach

                <a href="{{ route('home') }}" class="back-link"><i class="fas fa-arrow-left"></i> Lanjut Belanja</a>
            </div>

            <div class="col-lg-4">
                <div class="cart-summary-card">
                    <h6 class="fw-bold mb-3">Ringkasan Belanja</h6>
                    <div class="summary-row"><span>Total Item</span><span id="cartItemCount">{{ count($items) }} produk</span></div>
                    <div class="summary-row"><span>Subtotal</span><span id="cartSubtotal">Rp {{ number_format($total, 0, ',', '.') }}</span></div>
                    <div class="summary-row"><span>Ongkir</span><span class="text-success fw-semibold">GRATIS</span></div>
                    <div class="summary-row summary-total"><span>Total Bayar</span><span id="cartGrandTotal">Rp {{ number_format($total, 0, ',', '.') }}</span></div>

                    <button type="button" class="btn-whatsapp-demo mt-3" data-bs-toggle="modal" data-bs-target="#checkoutModal">
                        <i class="fab fa-whatsapp"></i> Pesan via WhatsApp
                    </button>
                    <p class="text-muted small text-center mt-2 mb-0">
                        *Order akan tercatat di sistem &amp; tidak benar-benar membuka WhatsApp (demo).
                    </p>
                </div>
            </div>
        </div>

        <div class="modal fade" id="checkoutModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="checkoutForm" onsubmit="return submitCheckout(event)">
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="fab fa-whatsapp text-success me-2"></i>Pesan via WhatsApp</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div id="checkoutError" class="alert alert-danger py-2 small mb-3" style="display:none;"></div>

                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" id="checkoutName" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nomor HP / WhatsApp</label>
                                <input type="tel" id="checkoutPhone" class="form-control" placeholder="08xx-xxxx-xxxx" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat Pengiriman</label>
                                <textarea id="checkoutAddress" class="form-control" rows="2" required></textarea>
                            </div>

                            <hr>
                            <h6 class="small fw-bold text-uppercase text-muted mb-2">Rincian Pesanan</h6>
                            <ul class="list-unstyled small mb-2" id="checkoutItemsList" style="max-height:150px; overflow-y:auto;">
                                @foreach ($items as $item)
                                    <li class="d-flex justify-content-between mb-1">
                                        <span>{{ $item['product']->name }} <span class="text-muted">x{{ $item['qty'] }}</span></span>
                                        <span>Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="d-flex justify-content-between fw-bold border-top pt-2">
                                <span>Total</span>
                                <span id="checkoutTotal">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn-whatsapp-demo w-100" id="checkoutSubmitBtn">
                                <i class="fab fa-whatsapp"></i> Pesan Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-shopping-cart"></i>
            <h5>Keranjang belanja kamu masih kosong</h5>
            <p>Yuk, mulai belanja produk HiLo favoritmu!</p>
            <a href="{{ route('products.index') }}" class="btn-hero"><i class="fas fa-shopping-bag"></i> Belanja Sekarang</a>
        </div>
    @endif

    {{-- Modal sukses dengan animasi centang --}}
    <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content text-center p-4">
                <div class="success-check mx-auto mb-3">
                    <i class="fas fa-check"></i>
                </div>
                <h5 class="fw-bold mb-2">Pesanan Diproses!</h5>
                <p class="text-muted small mb-3">Terima kasih, pesanan kamu sedang diproses. Tim kami akan segera menghubungi lewat WhatsApp untuk konfirmasi.</p>
                <button type="button" class="btn-hero justify-content-center" onclick="window.location.href='{{ route('cart.index') }}'">Oke, Mengerti</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function formatRupiah(n) {
        return 'Rp ' + Math.round(n).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    // ==== Update jumlah (qty) di keranjang tanpa reload ====
    document.querySelectorAll('.cart-qty-form').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const row = form.closest('.cart-item-card');

            fetch(form.action, {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                body: new FormData(form)
            })
            .then(function (res) { return res.json(); })
            .then(function (data) {
                if (!data.success) return;

                const qtyInput = form.querySelector('input[name=qty]');
                qtyInput.value = data.qty;
                row.querySelector('.item-subtotal').textContent = formatRupiah(data.subtotal);

                recalcCartTotals();
                updateCartBadge(data.cartCount);
            });
        });
    });

    // ==== Hapus item dari keranjang tanpa reload ====
    document.querySelectorAll('.cart-remove-form').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            fetch(form.action, {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                body: new FormData(form)
            })
            .then(function (res) { return res.json(); })
            .then(function (data) {
                if (!data.success) return;
                form.closest('.cart-item-card').remove();
                updateCartBadge(data.cartCount);

                if (data.cartCount === 0) {
                    window.location.href = "{{ route('cart.index') }}";
                    return;
                }
                recalcCartTotals();
            });
        });
    });

    function recalcCartTotals() {
        let total = 0;
        let count = 0;
        document.querySelectorAll('.cart-item-card').forEach(function (row) {
            const subtotalText = row.querySelector('.item-subtotal').textContent;
            total += parseInt(subtotalText.replace(/[^0-9]/g, ''), 10);
            count++;
        });

        const subtotalEl = document.getElementById('cartSubtotal');
        const grandTotalEl = document.getElementById('cartGrandTotal');
        const itemCountEl = document.getElementById('cartItemCount');
        const checkoutTotalEl = document.getElementById('checkoutTotal');

        if (subtotalEl) subtotalEl.textContent = formatRupiah(total);
        if (grandTotalEl) grandTotalEl.textContent = formatRupiah(total);
        if (itemCountEl) itemCountEl.textContent = count + ' produk';
        if (checkoutTotalEl) checkoutTotalEl.textContent = formatRupiah(total);

        // sinkronkan rincian pesanan di modal checkout
        const list = document.getElementById('checkoutItemsList');
        if (list) {
            list.innerHTML = '';
            document.querySelectorAll('.cart-item-card').forEach(function (row) {
                const name = row.querySelector('.cart-item-name').textContent.trim();
                const qty = row.querySelector('input[name=qty]').value;
                const subtotal = row.querySelector('.item-subtotal').textContent;
                const li = document.createElement('li');
                li.className = 'd-flex justify-content-between mb-1';
                li.innerHTML = '<span>' + name + ' <span class="text-muted">x' + qty + '</span></span><span>' + subtotal + '</span>';
                list.appendChild(li);
            });
        }
    }

    // updateCartBadge sudah didefinisikan secara global di layouts/app.blade.php

    // ==== Submit form checkout: benar-benar bikin Order + kurangi stok di server ====
    function submitCheckout(e) {
        e.preventDefault();

        const errorBox = document.getElementById('checkoutError');
        const submitBtn = document.getElementById('checkoutSubmitBtn');
        errorBox.style.display = 'none';
        submitBtn.disabled = true;

        const formData = new FormData();
        formData.append('name', document.getElementById('checkoutName').value);
        formData.append('phone', document.getElementById('checkoutPhone').value);
        formData.append('address', document.getElementById('checkoutAddress').value);

        fetch("{{ route('cart.checkout') }}", {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(function (res) { return res.json().then(function (data) { return { ok: res.ok, data: data }; }); })
        .then(function (result) {
            submitBtn.disabled = false;

            if (!result.ok || !result.data.success) {
                errorBox.textContent = result.data.message || 'Gagal memproses pesanan, silakan coba lagi.';
                errorBox.style.display = 'block';
                return;
            }

            const checkoutEl = document.getElementById('checkoutModal');
            const checkoutModal = bootstrap.Modal.getInstance(checkoutEl) || new bootstrap.Modal(checkoutEl);
            checkoutModal.hide();

            setTimeout(function () {
                const successEl = document.getElementById('successModal');
                new bootstrap.Modal(successEl).show();
            }, 350);
        })
        .catch(function () {
            submitBtn.disabled = false;
            errorBox.textContent = 'Terjadi kesalahan koneksi, silakan coba lagi.';
            errorBox.style.display = 'block';
        });

        return false;
    }
</script>
@endsection
