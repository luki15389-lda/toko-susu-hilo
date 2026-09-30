<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['customer_name', 'phone', 'address', 'total', 'status'];

    public const STATUSES = ['Menunggu Konfirmasi', 'Diproses', 'Dikirim', 'Selesai', 'Dibatalkan'];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function formattedTotal(): string
    {
        return 'Rp ' . number_format($this->total, 0, ',', '.');
    }
}
