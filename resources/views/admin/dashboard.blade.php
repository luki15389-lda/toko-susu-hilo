@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="text-muted small">Total Produk</div>
                    <div class="fs-3 fw-bold">{{ $totalProducts }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="text-muted small">Total Stok</div>
                    <div class="fs-3 fw-bold">{{ $totalStock }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="text-muted small">Produk Stok Habis</div>
                    <div class="fs-3 fw-bold text-danger">{{ $outOfStock }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="text-muted small">Order Baru</div>
                    <div class="fs-3 fw-bold text-warning">{{ $pendingOrders }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white d-flex justify-content-between">
                    <span>Order Terbaru</span>
                    <a href="{{ route('admin.orders.index') }}" class="small">Lihat semua</a>
                </div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead>
                            <tr><th>Pelanggan</th><th>Total</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                            @forelse ($latestOrders as $order)
                                <tr>
                                    <td><a href="{{ route('admin.orders.show', $order) }}">{{ $order->customer_name }}</a></td>
                                    <td>{{ $order->formattedTotal() }}</td>
                                    <td>
                                        <span class="badge {{ $order->status === 'Menunggu Konfirmasi' ? 'bg-warning text-dark' : 'bg-success' }}">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center text-muted py-3">Belum ada order</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">Produk Terbaru</div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead>
                            <tr><th>Nama</th><th>Kategori</th><th>Harga</th><th>Stok</th></tr>
                        </thead>
                        <tbody>
                            @forelse ($latestProducts as $p)
                                <tr>
                                    <td>{{ $p->name }}</td>
                                    <td>{{ $p->category }}</td>
                                    <td>{{ $p->formattedPrice() }}</td>
                                    <td>{{ $p->stock }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-3">Belum ada produk</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
