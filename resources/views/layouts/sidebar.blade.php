<nav id="sidebar" class="p-3 text-white">
    <h6 class="text-center mb-4">Sistem Informasi Manajemen Tugas Akhir</h6>

    <div class="d-flex flex-column flex-grow-1" style="height: 100%;">
        <ul class="nav flex-column">
            <a class="nav-link {{ Request::is('dashboard') ? 'active fw-bold bg-light text-dark' : '' }}"
                href="/dashboard">
                <i class="fas fa-home" style="width: 30px;"></i>Dashboard
            </a>
            <a class="nav-link {{ Request::is('pengajuan*') ? 'active fw-bold bg-light text-dark' : '' }}"
                href="/pengajuan">
                <i class="fas fa-book-reader" style="width: 30px;"></i>Pengajuan Judul
            </a>
            <a class="nav-link {{ Request::is('bimbingan') ? 'active fw-bold bg-light text-dark' : '' }}"
                href="/bimbingan">
                <i class="fas fa-chalkboard-teacher" style="width: 30px;"></i>Bimbingan
            </a>
            <a class="nav-link {{ Request::is('penjadwalan') ? 'active fw-bold bg-light text-dark' : '' }}"
                href="/penjadwalan">
                <i class="fas fa-calendar-alt" style="width: 30px;"></i>Penjadwalan
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
                            href="/seminar-proposal">
                            - Seminar Proposal
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('tugas-akhir') ? 'active fw-bold text-white' : 'text-white' }}"
                            href="/tugas-akhir">
                            - Sidang Tugas Akhir
                        </a>
                    </li>
                </ul>
            </div>

            @if (auth()->user()->role_id == 1)
                <a class="nav-link {{ Request::is('user') ? 'active fw-bold bg-light text-dark' : '' }}" href="/user">
                    <i class="fas fa-users" style="width: 30px;"></i>Data User
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
