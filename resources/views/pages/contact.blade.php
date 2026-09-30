@extends('layouts.app')

@section('title', 'Kontak - HiLo Store')

@section('content')
<div class="container">
    <div class="hero">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <h1>Hubungi Kami</h1>
                <p>Ada pertanyaan seputar produk atau pesanan? Tim kami siap membantu.</p>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="contact-section h-100">
                <h4 class="section-heading"><i class="fas fa-address-card"></i> Informasi Kontak</h4>

                <div class="contact-info-item">
                    <span class="icon"><i class="fas fa-map-marker-alt"></i></span>
                    <div>
                        <h6>Alamat Toko</h6>
                        <p>Jakarta</p>
                    </div>
                </div>
                <div class="contact-info-item">
                    <span class="icon"><i class="fab fa-whatsapp"></i></span>
                    <div>
                        <h6>WhatsApp</h6>
                        <p>0812-3456-7890</p>
                    </div>
                </div>
                <div class="contact-info-item">
                    <span class="icon"><i class="fas fa-envelope"></i></span>
                    <div>
                        <h6>Email</h6>
                        <p>info@hilostore.com</p>
                    </div>
                </div>
                <div class="contact-info-item">
                    <span class="icon"><i class="fas fa-clock"></i></span>
                    <div>
                        <h6>Jam Operasional</h6>
                        <p>Senin - Sabtu: 08.00 - 20.00<br>Minggu: 09.00 - 15.00</p>
                    </div>
                </div>

                <h6 class="mt-4 mb-2">Ikuti Kami</h6>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="contact-section h-100">
                <h4 class="section-heading"><i class="fas fa-paper-plane"></i> Kirim Pesan</h4>
                <p class="section-sub mb-3">*Form ini contoh tampilan untuk keperluan demo, belum terhubung ke sistem pengiriman pesan sungguhan.</p>

                <form onsubmit="event.preventDefault(); showToast('Ini form demo — pesan tidak benar-benar terkirim.'); this.reset();">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" placeholder="Nama kamu">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" placeholder="email@contoh.com">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Pesan</label>
                            <textarea class="form-control" rows="4" placeholder="Tulis pesan kamu di sini..."></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn-hero"><i class="fas fa-paper-plane"></i> Kirim Pesan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
