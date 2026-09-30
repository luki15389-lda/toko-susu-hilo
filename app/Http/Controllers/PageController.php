<?php

namespace App\Http\Controllers;

use App\Models\Product;

class PageController extends Controller
{
    public function about()
    {
        return view('pages.about');
    }

    public function promo()
    {
        $promoProducts = Product::where('is_active', true)->where('is_promo', true)->get();
        if ($promoProducts->isEmpty()) {
            $promoProducts = Product::where('is_active', true)->latest()->limit(8)->get();
        }

        return view('pages.promo', compact('promoProducts'));
    }

    public function contact()
    {
        return view('pages.contact');
    }
}
