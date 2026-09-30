<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// ==== Halaman publik (toko) ====
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/produk', [ProductController::class, 'index'])->name('products.index');
Route::get('/produk/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/tentang-kami', [PageController::class, 'about'])->name('about');
Route::get('/promo', [PageController::class, 'promo'])->name('promo');
Route::get('/kontak', [PageController::class, 'contact'])->name('contact');

// ==== Keranjang belanja (session, tanpa login) ====
Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
Route::post('/keranjang/{product}/tambah', [CartController::class, 'add'])->name('cart.add');
Route::post('/keranjang/{product}/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/keranjang/{product}/hapus', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/keranjang/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

// ==== Login admin ====
// Catatan: URL-nya sengaja dibuat acak/tidak lazim (bukan /admin/login) supaya lebih sulit
// ditebak orang lain, dan TIDAK ada link ke sini dari halaman publik manapun.
// Kalau mau ganti kode rahasianya, cukup ubah string 'tsh-back-4il0' di bawah ini.
Route::get('/tsh-back-4il0/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/tsh-back-4il0/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/tsh-back-4il0/logout', [AuthController::class, 'logout'])->name('admin.logout');

// ==== Area admin (dilindungi middleware admin) ====
Route::middleware('admin')->prefix('tsh-back-4il0')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', AdminProductController::class)->except(['show']);
    Route::resource('categories', AdminCategoryController::class)->except(['show']);
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
});
