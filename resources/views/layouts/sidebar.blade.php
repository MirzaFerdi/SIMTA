<nav id="sidebar" class="p-3 text-white">
    <div class="text-center mb-4">
        <img src="{{ asset('image/logo2.png') }}" alt="Logo SIMTA" style="width: 100%; max-width: none;">
    </div>

    <div class="d-flex flex-column flex-grow-1" style="height: 100%;">
        <ul class="nav flex-column">
            <a class="nav-link {{ Request::is('dashboard') ? 'active fw-bold bg-light text-dark' : '' }}"
                href="/dashboard">
                <i class="fas fa-home" style="width: 30px;"></i>Dashboard
            </a>

            @if (auth()->user()->role_id == 1)
            <a class="nav-link {{ Request::is('user') ? 'active fw-bold bg-light text-dark' : '' }}" href="/user">
                <i class="fas fa-users" style="width: 30px;"></i>Data User
            </a>
            <a class="nav-link {{ Request::is('dospem') ? 'active fw-bold bg-light text-dark' : '' }}" href="/dospem">
                <i class="fas fa-user-tie" style="width: 30px;"></i>Dosen Pembimbing
            </a>
            @endif


            <a class="nav-link {{ Request::is('penjadwalan') ? 'active fw-bold bg-light text-dark' : '' }}"
                href="/penjadwalan">
                <i class="fas fa-calendar-alt" style="width: 30px;"></i>Penjadwalan
            </a>

            @if (auth()->user()->role_id == 2 || auth()->user()->role_id == 3)
            <a class="nav-link {{ Request::is('pengajuan*') ? 'active fw-bold bg-light text-dark' : '' }}"
                href="/pengajuan">
                <i class="fas fa-book-reader" style="width: 30px;"></i>Pengajuan Judul
            </a>
            <a class="nav-link {{ Request::is('bimbingan') ? 'active fw-bold bg-light text-dark' : '' }}"
                href="/bimbingan">
                <i class="fas fa-chalkboard-teacher" style="width: 30px;"></i>Bimbingan
            </a>

            @php
            $isUjian = Request::is('admin/ujian/*');
            @endphp

            <div class="nav-item">
                <a href="#"
                    class="nav-link text-white d-flex justify-content-between align-items-center {{ $isUjian ? 'fw-bold bg-light text-dark' : '' }}"
                    id="toggleUjian">
                    <span><i class="fas fa-book" style="width: 30px;"></i>Ujian</span>
                    <i class="fas fa-chevron-down small" id="ujianChevron"></i>
                </a>
                <ul class="nav flex-column ms-4 mt-2 slide-toggle {{ $isUjian ? 'show' : '' }}" id="ujianSubmenu">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('seminar-proposal') ? 'active fw-bold text-white' : 'text-white' }}"
                            href="/seminar-proposal" style="font-size: 14px;">
                            <i class="fa-solid fa-book-open-reader"></i> Seminar Proposal
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('rekap-seminar') ? 'active fw-bold text-white' : 'text-white' }}"
                            href="/rekap-seminar" style="font-size: 14px;">
                            <i class="fa-solid fa-book-open"></i> Rekap Hasil Seminar
                        </a>
                    </li>
                </ul>
            </div>
            @endif


            @if (auth()->user()->role_id == 1)
            <a class="nav-link {{ Request::is('berita-acara') ? 'active fw-bold bg-light text-dark' : '' }}" href="/berita-acara">
                <i class="fas fa-file" style="width: 30px;"></i>Berita Acara
            </a>
            <a class="nav-link {{ Request::is('rekap-seminar') ? 'active fw-bold bg-light text-dark' : '' }}" href="/rekap-seminar">
                <i class="fab fa-readme" style="width: 30px;"></i>Rekap Hasil Seminar
            </a>
            @endif

            <a class="nav-link {{ Request::is('profile') ? 'active fw-bold bg-light text-dark' : '' }}" href="/profile">
                <i class="fas fa-user-alt" style="width: 30px;"></i>Profile
            </a>
            </li>
        </ul>

        <ul class="nav flex-column mt-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}">
                    <i class="fas fa-sign-out-alt" style="width: 30px;"></i> Logout
                </a>
            </li>
        </ul>
    </div>
</nav>
