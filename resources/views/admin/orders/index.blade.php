@extends('admin.layout')

@section('title', 'Order Masuk')

@section('content')
    <div class="d-flex justify-content-between mb-3 flex-wrap gap-2">
        <form method="GET" class="d-flex gap-2">
            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                @foreach (\App\Models\Order::STATUSES as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>
                @endforeach
            </select>
        </form>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Pelanggan</th>
                        <th>No HP</th>
                        <th>Item</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->customer_name }}</td>
                            <td>{{ $order->phone }}</td>
                            <td>{{ $order->items_count }} produk</td>
                            <td>{{ $order->formattedTotal() }}</td>
                            <td>
                                <span class="badge {{ $order->status === 'Menunggu Konfirmasi' ? 'bg-warning text-dark' : ($order->status === 'Dibatalkan' ? 'bg-danger' : 'bg-success') }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="small text-muted">{{ $order->created_at->format('d M Y, H:i') }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-muted py-4">Belum ada order masuk.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $orders->links() }}</div>
@endsection
