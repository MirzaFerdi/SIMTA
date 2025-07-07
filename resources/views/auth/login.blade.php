<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Informasi Manajemen Tugas Akhir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background-image: url('{{ asset('image/background.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            min-width: 350px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, .15);
        }
    </style>
</head>

<body>
    @if (session('error'))
        <div class="alert alert-danger alert-fixed d-flex align-items-start alert-dismissible fade show shadow"
            role="alert" id="error-alert"
            style="position: fixed; top: 20px; right: 20px; z-index: 1050; min-width: 300px;">
            <i class="bi bi-exclamation-triangle-fill me-2 fs-5 mt-1"></i>
            <div>
                <strong>Gagal!</strong> {{ session('error') }}
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    <div class="card login-card p-4">
        <div class="card-body">
            <div class="text-center mb-3">
                <img src="{{ asset('image/polinema.png') }}" alt="Logo SIMTA" style="max-width: 100px;">
            </div>
            <h4 class="card-title text-center mb-4">Login SIMTA</h4>
            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        setTimeout(function() {
            var alert = document.getElementById('success-alert');
            if (alert) {
                alert.remove();
            }
        }, 3000);

        setTimeout(function() {
            var alert = document.getElementById('error-alert');
            if (alert) {
                alert.remove();
            }
        }, 3000);
    </script>
</body>

</html>
