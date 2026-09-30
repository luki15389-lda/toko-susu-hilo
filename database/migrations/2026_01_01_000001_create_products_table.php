<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('category');
            $table->unsignedBigInteger('price'); // harga dalam rupiah, angka polos
            $table->unsignedInteger('stock')->default(0);
            $table->string('image')->nullable(); // nama file di storage/app/public/products
            $table->text('description')->nullable();
            $table->text('benefits')->nullable(); // dipisah baris baru, satu manfaat per baris
            $table->text('composition')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
