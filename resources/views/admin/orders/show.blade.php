@extends('admin.layout')

@section('title', 'Detail Order #' . $order->id)

@section('content')
    <a href="{{ route('admin.orders.index') }}" class="btn btn-link px-0 mb-3"><i class="fas fa-arrow-left"></i> Kembali ke daftar order</a>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white fw-bold">Item Pesanan</div>
                <div class="card-body p-0">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $item)
                                <tr>
                                    <td>
                                        {{ $item->product_name }}
                                        @if (!$item->product)
                                            <span class="badge bg-secondary ms-1">produk sudah dihapus</span>
                                        @endif
                                    </td>
                                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td>{{ $item->qty }}</td>
                                    <td>{{ $item->formattedSubtotal() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end fw-bold">Total</td>
                                <td class="fw-bold">{{ $order->formattedTotal() }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white fw-bold">Info Pelanggan</div>
                <div class="card-body">
                    <p class="mb-2"><i class="fas fa-user text-muted me-2"></i>{{ $order->customer_name }}</p>
                    <p class="mb-2"><i class="fab fa-whatsapp text-muted me-2"></i>{{ $order->phone }}</p>
                    <p class="mb-0"><i class="fas fa-map-marker-alt text-muted me-2"></i>{{ $order->address }}</p>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white fw-bold">Status Pesanan</div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="d-flex gap-2">
                        @csrf
                        <select name="status" class="form-select">
                            @foreach (\App\Models\Order::STATUSES as $status)
                                <option value="{{ $status }}" @selected($order->status === $status)>{{ $status }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-success text-nowrap"><i class="fas fa-save"></i> Simpan</button>
                    </form>
                    <p class="text-muted small mt-2 mb-0">Dipesan {{ $order->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
