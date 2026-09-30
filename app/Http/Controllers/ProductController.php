<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // halaman utama: daftar produk aktif, bisa difilter kategori & pencarian
    public function index(Request $request)
    {
        $query = Product::query()->where('is_active', true);

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        $products = $query->orderBy('name')->paginate(8)->withQueryString();

        if ($request->ajax()) {
            return view('products._grid', compact('products'));
        }

        $categories = Product::categories();

        $totalAll = Product::where('is_active', true)->count();
        $categoryCounts = Product::where('is_active', true)
            ->selectRaw('category, count(*) as total')
            ->groupBy('category')
            ->pluck('total', 'category');

        return view('products.index', compact('products', 'categories', 'totalAll', 'categoryCounts'));
    }

    // halaman detail produk
    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)->where('is_active', true)->firstOrFail();

        $related = Product::where('is_active', true)
            ->where('id', '!=', $product->id)
            ->where('category', $product->category)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'related'));
    }
}
