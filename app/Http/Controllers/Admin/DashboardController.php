<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalStock = Product::sum('stock');
        $outOfStock = Product::where('stock', 0)->count();
        $latestProducts = Product::latest()->limit(5)->get();

        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'Menunggu Konfirmasi')->count();
        $latestOrders = Order::withCount('items')->latest()->limit(5)->get();

        return view('admin.dashboard', compact(
            'totalProducts', 'totalStock', 'outOfStock', 'latestProducts',
            'totalOrders', 'pendingOrders', 'latestOrders'
        ));
    }
}
