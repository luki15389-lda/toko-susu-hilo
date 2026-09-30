<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name')->get();

        // produk unggulan: diambil dari yang ditandai admin, fallback ke produk terbaru kalau belum ada yang ditandai
        $featured = Product::where('is_active', true)->where('is_featured', true)->limit(8)->get();
        if ($featured->isEmpty()) {
            $featured = Product::where('is_active', true)->where('stock', '>', 0)->latest()->limit(8)->get();
        }

        // produk promo: diambil dari yang ditandai admin, fallback ke produk lain kalau belum ada
        $promoProducts = Product::where('is_active', true)->where('is_promo', true)->limit(4)->get();
        if ($promoProducts->isEmpty()) {
            $promoProducts = Product::where('is_active', true)->latest()->limit(4)->get();
        }

        return view('home', compact('categories', 'featured', 'promoProducts'));
    }
}
