<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manajemen TA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">

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
