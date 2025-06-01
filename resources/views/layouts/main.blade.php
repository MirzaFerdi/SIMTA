<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manajemen TA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    @yield('styles')

    <style>
        body {
            min-height: 100vh;
            margin: 0;
        }

        .slide-toggle {
            overflow: hidden;
            max-height: 0;
            transition: max-height 0.3s ease;
        }

        .slide-toggle.show {
            max-height: 500px;
        }

        #sidebar {
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 1030;
            min-width: 250px;
            max-width: 250px;
            background-color: #29146B;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            /* ini bisa juga */
            transition: all 0.3s ease;
        }

        #sidebar .nav-link {
            color: #fff;
        }

        #sidebar .nav-link:hover {
            background-color: #462aa4;
        }

        .alert-fixed {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1055;
            min-width: 300px;
            max-width: 400px;
            animation: slideDown 0.4s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        #content {
            flex-grow: 1;
        }

        @media (max-width: 768px) {
            #sidebar {
                position: fixed;
                top: 0;
                left: -250px;
                height: 100vh;
                z-index: 1045;
            }

            #sidebar.active {
                left: 0;
            }

            #overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1040;
            }

            #overlay.active {
                display: block;
            }
        }

        footer {
            background-color: #f8f9fa;
            text-align: center;
            padding: 10px 0;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <div id="overlay"></div>

    <div class="d-flex flex-grow-1">
        @include('layouts.sidebar')

        <div id="content" class="d-flex flex-column w-100">
            @include('layouts.navbar')

            @if (session('success'))
                <div class="alert alert-success alert-fixed d-flex align-items-center alert-dismissible fade show shadow"
                    role="alert" id="success-alert">
                    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                    <div>
                        <strong>Berhasil!</strong> {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-fixed d-flex align-items-start alert-dismissible fade show shadow"
                    role="alert" id="error-alert">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-5 mt-1"></i>
                    <div>
                        <strong>Gagal!</strong> Silakan periksa inputan Anda.
                        <ul class="mb-0 mt-2 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                </div>
            @endif


            <main class="flex-grow-1 p-4">

                @yield('content')
            </main>

            @include('layouts.footer')
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');

            toggleBtn?.addEventListener('click', () => {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
            });

            overlay?.addEventListener('click', () => {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            });
        });
    </script>

    <script>
        const toggleBtn = document.getElementById('toggleUjian');
        const submenu = document.getElementById('ujianSubmenu');
        const chevron = document.getElementById('ujianChevron');

        toggleBtn?.addEventListener('click', function(e) {
            e.preventDefault();
            submenu.classList.toggle('show');
            chevron.classList.toggle('rotate-180');
        });
    </script>

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

    <style>
        .rotate-180 {
            transform: rotate(180deg);
            transition: transform 0.3s ease;
        }
    </style>

    @yield('scripts')

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js"
        integrity="sha384-RuyvpeZCxMJCqVUGFI0Do1mQrods/hhxYlcVfGPOfQtPJh0JCw12tUAZ/Mv10S7D" crossorigin="anonymous">
    </script>
</body>

</html>
