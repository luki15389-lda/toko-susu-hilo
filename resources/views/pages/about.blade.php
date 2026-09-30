@extends('layouts.app')

@section('title', 'Tentang Kami - HiLo Store')

@section('content')
<div class="container">

    <div class="hero">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <h1>Tentang HiLo Store</h1>
                <p>Mitra terpercaya keluarga Indonesia untuk kebutuhan nutrisi susu berkualitas sejak awal berdiri.</p>
            </div>
        </div>
    </div>

    <div class="about-section">
        <div class="row g-4 align-items-center">
            <div class="col-lg-7">
                <h4 class="section-heading"><i class="fas fa-store"></i> Siapa Kami</h4>
                <p class="text-secondary">
                    HiLo Store hadir untuk memudahkan kamu mendapatkan berbagai pilihan produk HiLo secara praktis dan nyaman.
                    Kami adalah distributor resmi yang fokus menghadirkan susu HiLo untuk berbagai tahap usia — mulai dari remaja,
                    usia sekolah, dewasa aktif, hingga lanjut usia — dengan jaminan produk 100% original dan harga yang bersahabat.
                </p>
                <p class="text-secondary">
                    Kami percaya bahwa nutrisi yang tepat adalah pondasi gaya hidup sehat. Karena itu, tim kami berkomitmen
                    memberikan pelayanan cepat, ramah, dan informasi produk yang jelas agar kamu bisa memilih susu HiLo
                    yang paling sesuai dengan kebutuhanmu.
                </p>
            </div>
            <div class="col-lg-5 text-center">
                <img src="{{ asset('assets/images/produk2.webp') }}" class="img-fluid" style="max-height:240px;" alt="Tentang Kami">
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-6 col-md-3">
            <div class="trust-card">
                <i class="fas fa-bullseye"></i>
                <h6>Misi Kami</h6>
                <p>Menyediakan nutrisi terbaik untuk keluarga Indonesia</p>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="trust-card">
                <i class="fas fa-eye"></i>
                <h6>Visi Kami</h6>
                <p>Jadi toko susu HiLo online terpercaya no.1</p>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="trust-card">
                <i class="fas fa-handshake"></i>
                <h6>Nilai Kami</h6>
                <p>Jujur, cepat, dan mengutamakan pelanggan</p>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="trust-card">
                <i class="fas fa-users"></i>
                <h6>Ribuan Pelanggan</h6>
                <p>Dipercaya keluarga di seluruh Indonesia</p>
            </div>
        </div>
    </div>

    <div class="text-center mb-5">
        <a href="{{ route('products.index') }}" class="btn-hero"><i class="fas fa-shopping-bag"></i> Mulai Belanja</a>
    </div>
</div>
@endsection
