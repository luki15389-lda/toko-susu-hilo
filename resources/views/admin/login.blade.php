<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin - Toko Susu HiLo</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="alternate icon" href="{{ asset('favicon.svg') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container d-flex align-items-center justify-content-center" style="min-height:100vh;">
        <div class="card shadow-sm" style="width: 100%; max-width: 380px;">
            <div class="card-body p-4">
                <h4 class="text-center mb-3 fw-bold text-success">Login Admin</h4>
                <p class="text-center text-muted small">Toko Susu HiLo</p>

                @if ($errors->any())
                    <div class="alert alert-danger py-2">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login.submit') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">Ingat saya</label>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Masuk</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
