<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan | HiLo Store</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
</head>
<body class="notfound-page">

    <div class="notfound-wrap">
        <div class="notfound-icon">
            <i class="far fa-frown"></i>
        </div>

        <div class="notfound-code">404</div>
        <h1 class="notfound-title">Halaman Tidak Ditemukan</h1>
        <p class="notfound-text">
            Sepertinya susu yang kamu cari sudah habis,<br class="d-none d-md-inline">
            atau halamannya memang tidak ada.
        </p>

        <div class="notfound-actions">
            <a href="{{ route('home') }}" class="btn-hero-outline">
                <i class="fas fa-home"></i> Kembali ke Beranda
            </a>
        </div>
    </div>

</body>
</html>