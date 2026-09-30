<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query()
            ->when($request->filled('q'), fn ($q) => $q->where('name', 'like', '%' . $request->q . '%'))
            ->when($request->boolean('promo'), fn ($q) => $q->where('is_promo', true))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    public function create(Request $request)
    {
        $categories = Product::categories();
        $product = new Product();

        // datang dari menu "Promo" -> otomatis centang Produk Promo
        if ($request->boolean('promo')) {
            $product->is_promo = true;
        }

        return view('admin.products.form', [
            'product' => $product,
            'categories' => $categories,
            'fromPromo' => $request->boolean('promo'),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            $data['image'] = $this->storeImage($request);
        }

        $data['slug'] = Str::slug($data['name']) . '-' . Str::random(5);
        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_promo'] = $request->boolean('is_promo');
        $data['discount_percent'] = $data['is_promo'] ? ($data['discount_percent'] ?? 0) : 0;

        Product::create($data);

        return redirect()
            ->route('admin.products.index', $data['is_promo'] ? ['promo' => 1] : [])
            ->with('status', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $categories = Product::categories();
        return view('admin.products.form', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validated($request, $product->id);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete('products/' . $product->image);
            }
            $data['image'] = $this->storeImage($request);
        }

        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_promo'] = $request->boolean('is_promo');
        $data['discount_percent'] = $data['is_promo'] ? ($data['discount_percent'] ?? 0) : 0;

        $product->update($data);

        return redirect()
            ->route('admin.products.index', $data['is_promo'] ? ['promo' => 1] : [])
            ->with('status', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete('products/' . $product->image);
        }

        $product->delete();

        return back()->with('status', 'Produk berhasil dihapus.');
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'benefits' => ['nullable', 'string'],
            'composition' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'discount_percent' => ['nullable', 'integer', 'min:0', 'max:90'],
        ]);
    }

    private function storeImage(Request $request): string
    {
        $path = $request->file('image')->store('products', 'public');
        return basename($path);
    }
}
