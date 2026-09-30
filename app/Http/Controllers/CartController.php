<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $items = [];
        $total = 0;

        if (!empty($cart)) {
            $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');

            foreach ($cart as $id => $qty) {
                if (!isset($products[$id])) {
                    continue;
                }

                $product = $products[$id];
                $qty = min($qty, max($product->stock, 1)); // jangan melebihi stok
                $subtotal = $product->effectivePrice() * $qty;

                $items[] = [
                    'product' => $product,
                    'qty' => $qty,
                    'subtotal' => $subtotal,
                ];

                $total += $subtotal;
            }
        }

        return view('cart.index', compact('items', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $qty = max(1, (int) $request->input('qty', 1));

        if ($product->stock <= 0) {
            $message = 'Maaf, stok produk ini sedang habis.';

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $message]);
            }

            return back()->with('status', $message);
        }

        $cart = session('cart', []);
        $cart[$product->id] = min(($cart[$product->id] ?? 0) + $qty, $product->stock);
        session(['cart' => $cart]);

        $message = $product->name . ' berhasil ditambahkan ke keranjang.';

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'cartCount' => collect(session('cart', []))->sum(),
            ]);
        }

        return back()->with('status', $message);
    }

    public function update(Request $request, Product $product)
    {
        $qty = max(1, (int) $request->input('qty', 1));
        $cart = session('cart', []);

        if (isset($cart[$product->id])) {
            $qty = min($qty, max($product->stock, 1));
            $cart[$product->id] = $qty;
            session(['cart' => $cart]);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'qty' => $qty,
                'subtotal' => $product->effectivePrice() * $qty,
                'cartCount' => collect(session('cart', []))->sum(),
            ]);
        }

        return back();
    }

    public function remove(Request $request, Product $product)
    {
        $cart = session('cart', []);
        unset($cart[$product->id]);
        session(['cart' => $cart]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'cartCount' => collect(session('cart', []))->sum(),
            ]);
        }

        return back()->with('status', 'Produk dihapus dari keranjang.');
    }

    // Dipanggil saat customer submit form "Pesan via WhatsApp" di halaman keranjang.
    // Membuat record Order + OrderItem (supaya muncul di Admin > Order), mengurangi stok
    // produk secara otomatis, lalu mengosongkan keranjang.
    public function checkout(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'address' => ['required', 'string', 'max:1000'],
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return response()->json(['success' => false, 'message' => 'Keranjang kosong.'], 422);
        }

        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');
        $total = 0;
        $itemsData = [];

        foreach ($cart as $id => $qty) {
            if (!isset($products[$id])) {
                continue;
            }

            $product = $products[$id];
            $qty = min((int) $qty, $product->stock); // jaga-jaga kalau stok berubah sejak ditambahkan

            if ($qty <= 0) {
                continue;
            }

            $price = $product->effectivePrice();
            $subtotal = $price * $qty;
            $total += $subtotal;

            $itemsData[] = [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'price' => $price,
                'qty' => $qty,
                'subtotal' => $subtotal,
            ];
        }

        if (empty($itemsData)) {
            return response()->json(['success' => false, 'message' => 'Stok produk yang kamu pesan sudah habis.'], 422);
        }

        $order = Order::create([
            'customer_name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'total' => $total,
        ]);

        foreach ($itemsData as $item) {
            $order->items()->create($item);

            // kurangi stok otomatis sesuai jumlah yang dibeli
            Product::where('id', $item['product_id'])->decrement('stock', $item['qty']);
        }

        session()->forget('cart');

        return response()->json(['success' => true, 'order_id' => $order->id]);
    }
}
