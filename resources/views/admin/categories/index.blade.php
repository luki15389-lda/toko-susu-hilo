@extends('admin.layout')

@section('title', 'Kelola Kategori')

@section('content')
    <div class="d-flex justify-content-between mb-3">
        <p class="text-muted small mb-0">Kategori di sini otomatis muncul di halaman Produk &amp; Home (dropdown/form produk, sidebar filter, kartu kategori).</p>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-success btn-sm text-nowrap">
            <i class="fas fa-plus"></i> Tambah Kategori
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Nama Kategori</th>
                        <th>Jumlah Produk</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td><img src="{{ $category->imageUrl() }}" width="46" height="46" style="object-fit:cover;border-radius:8px;"></td>
                            <td>{{ $category->name }}</td>
                            <td><span class="badge bg-light text-dark">{{ $productCounts[$category->name] ?? 0 }} produk</span></td>
                            <td class="text-end">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus kategori ini? Produk yang sudah memakai nama kategori ini tidak akan ikut terhapus.')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">Belum ada kategori.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $categories->links() }}</div>
@endsection
