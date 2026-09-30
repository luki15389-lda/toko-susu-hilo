<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image'];

    public function imageUrl(): string
    {
        if ($this->image) {
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists('categories/' . $this->image)) {
                return asset('storage/categories/' . $this->image);
            }
            // fallback: kemungkinan ini nama file bawaan di public/assets/images (dari seeder awal)
            if (file_exists(public_path('assets/images/' . $this->image))) {
                return asset('assets/images/' . $this->image);
            }
        }

        return asset('assets/images/kategori1.webp');
    }
}
