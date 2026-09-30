<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Laravel bawaan pakai timezone UTC, jadi jam order/timestamp lain bisa selisih
        // beberapa jam dari waktu Indonesia sebenarnya. Baris ini menyamakannya ke WIB
        // supaya tanggal & jam di Admin > Order (dan timestamp lain) selalu real-time
        // sesuai waktu Indonesia.
        date_default_timezone_set('Asia/Jakarta');
    }
}
