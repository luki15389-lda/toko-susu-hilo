@extends('admin.layout')

@section('title', request('promo') ? 'Kelola Produk Promo' : 'Kelola Produk')

@section('content')
    @if (request('promo'))
        <div class="alert alert-warning py-2 d-flex justify-content-between align-items-center">
            <span><i class="fas fa-fire me-1"></i> Menampilkan produk yang ditandai <strong>Promo</strong> saja.</span>
            <a href="{{ route('admin.products.index') }}" class="small">Lihat semua produk</a>
        </div>
    @endif

    <div class="d-flex justify-content-between mb-3">
        <form method="GET" class="d-flex gap-2">
            @if (request('promo'))
                <input type="hidden" name="promo" value="1">
            @endif
            <input type="text" name="q" class="form-control form-control-sm" placeholder="Cari produk..." value="{{ request('q') }}">
            <button class="btn btn-sm btn-outline-secondary">Cari</button>
        </form>
        <a href="{{ route('admin.products.create', request('promo') ? ['promo' => 1] : []) }}" class="btn btn-success btn-sm">
            <i class="fas fa-plus"></i> {{ request('promo') ? 'Tambah Produk Promo' : 'Tambah Produk' }}
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td><img src="{{ $product->imageUrl() }}" width="50" height="50" style="object-fit:cover;border-radius:6px;"></td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category }}</td>
                            <td>
                                {{ $product->formattedPrice() }}
                                @if ($product->hasDiscount())
                                    <div class="small text-success fw-semibold">
                                        → {{ $product->formattedDiscountedPrice() }} (-{{ $product->discount_percent }}%)
                                    </div>
                                @endif
                            </td>
                            <td>{{ $product->stock }}</td>
                            <td>
                                @if ($product->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                                @if ($product->is_featured)
                                    <span class="badge bg-warning text-dark">Unggulan</span>
                                @endif
                                @if ($product->is_promo)
                                    <span class="badge bg-danger">Promo</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin hapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">Belum ada produk.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $products->links() }}</div>
@endsection
