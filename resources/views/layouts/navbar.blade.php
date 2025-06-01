<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm px-3">
    <button class="btn btn-outline-secondary me-2 d-md-none" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>
    <span class="navbar-brand ms-3">
        @php
            $currentRoute = Route::currentRouteName();
            $routeTitles = [
                'dashboard' => 'Dashboard',
                'profile' => 'Profil',
                'user' => 'Daftar User',
                'berita-acara' => 'Berita Acara',
                'rekap-seminar' => 'Rekap Hasil Seminar',
            ];
        @endphp
        {{ $routeTitles[$currentRoute] ?? ucfirst(str_replace('.', ' ', $currentRoute)) }}
    </span>
    <div class="ms-auto">
        <span class="me-3">{{ auth()->user()->nama }}</span>
    </div>
</nav>
