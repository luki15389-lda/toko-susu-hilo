@extends('admin.layout')

@section('title', $category->exists ? 'Edit Kategori' : 'Tambah Kategori')

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form method="POST"
                  action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
                  enctype="multipart/form-data">
                @csrf
                @if ($category->exists) @method('PUT') @endif

                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
                        @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                        <div class="form-text">Nama ini yang akan muncul di form produk, filter, dan tampilan publik.</div>
                    </div>

                    <div class="col-md-8">
                        <label class="form-label">Gambar Kategori</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        @if ($category->image)
                            <img src="{{ $category->imageUrl() }}" class="mt-2 rounded" width="80">
                        @endif
                        @error('image') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <button class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
