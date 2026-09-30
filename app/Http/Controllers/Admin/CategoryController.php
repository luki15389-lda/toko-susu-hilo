<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name')->paginate(10);

        // hitung jumlah produk per kategori (dicocokkan lewat nama, karena kategori di produk masih berupa teks)
        $productCounts = \App\Models\Product::selectRaw('category, count(*) as total')
            ->groupBy('category')
            ->pluck('total', 'category');

        return view('admin.categories.index', compact('categories', 'productCounts'));
    }

    public function create()
    {
        return view('admin.categories.form', ['category' => new Category()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            $data['image'] = basename($request->file('image')->store('categories', 'public'));
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('status', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.form', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $this->validated($request, $category->id);

        if ($request->hasFile('image')) {
            $data['image'] = basename($request->file('image')->store('categories', 'public'));
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('status', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        // Produk yang masih pakai nama kategori ini TIDAK ikut terhapus —
        // field 'category' di produk cuma teks biasa, jadi aman meski kategorinya dihapus.
        $category->delete();

        return back()->with('status', 'Kategori berhasil dihapus.');
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name' . ($ignoreId ? ",{$ignoreId}" : '')],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);
    }
}
