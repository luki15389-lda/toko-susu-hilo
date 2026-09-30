<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'price',
        'stock',
        'image',
        'description',
        'benefits',
        'composition',
        'is_active',
        'is_featured',
        'is_promo',
        'discount_percent',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_promo' => 'boolean',
        'price' => 'integer',
        'stock' => 'integer',
        'discount_percent' => 'integer',
    ];

    // Daftar nama kategori, sekarang diambil dari tabel `categories` (dikelola lewat Admin > Kategori).
    // Method ini tetap dipakai di banyak tempat (form produk, filter, dsb) supaya tidak perlu diubah satu-satu.
    public static function categories(): array
    {
        return Category::orderBy('name')->pluck('name')->toArray();
    }

    public function benefitsList(): array
    {
        if (empty($this->benefits)) {
            return [];
        }

        return array_filter(array_map('trim', explode("\n", $this->benefits)));
    }

    public function imageUrl(): string
    {
        return $this->image
            ? asset('storage/products/' . $this->image)
            : asset('assets/images/no-image.png');
    }

    public function formattedPrice(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    // Promo: harga otomatis berkurang sesuai discount_percent kalau produk ditandai promo
    public function hasDiscount(): bool
    {
        return $this->is_promo && $this->discount_percent > 0;
    }

    public function discountedPrice(): int
    {
        if (!$this->hasDiscount()) {
            return $this->price;
        }

        return (int) round($this->price - ($this->price * $this->discount_percent / 100));
    }

    public function formattedDiscountedPrice(): string
    {
        return 'Rp ' . number_format($this->discountedPrice(), 0, ',', '.');
    }

    // Harga yang benar-benar dipakai saat checkout/ditampilkan (sudah termasuk diskon kalau ada)
    public function effectivePrice(): int
    {
        return $this->hasDiscount() ? $this->discountedPrice() : $this->price;
    }

    protected static function booted(): void
    {
        static::saving(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name) . '-' . Str::random(5);
            }
        });
    }
}
