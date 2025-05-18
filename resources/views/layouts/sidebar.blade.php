<nav id="sidebar" class="p-3 text-white">
    <h6 class="text-center mb-4">Sistem Informasi Manajemen Tugas Akhir</h6>

    <div class="d-flex flex-column flex-grow-1" style="height: 100%;">
        <ul class="nav flex-column">
            <a class="nav-link {{ Request::is('dashboard') ? 'active fw-bold bg-light text-dark' : '' }}"
                href="/dashboard">
                <i class="fas fa-home me-2"></i>Dashboard
            </a>
            <a class="nav-link {{ Request::is('admin/pengajuan*') ? 'active fw-bold bg-light text-dark' : '' }}"
                href="/admin/penjadwalan">
                <i class="fas fa-book-reader me-2"></i>Pengajuan Judul
            </a>
            <a class="nav-link {{ Request::is('admin/penjadwalan') ? 'active fw-bold bg-light text-dark' : '' }}"
                href="/admin/penjadwalan">
                <i class="fas fa-calendar-alt me-2"></i>Penjadwalan
            </a>

            @php
                $isUjian = Request::is('admin/ujian/*');
            @endphp

            <div class="nav-item">
                <a href="#"
                    class="nav-link text-white d-flex justify-content-between align-items-center {{ $isUjian ? 'fw-bold bg-light text-dark' : '' }}"
                    id="toggleUjian">
                    <span><i class="fas fa-book me-2"></i>Ujian</span>
                    <i class="fas fa-chevron-down small" id="ujianChevron"></i>
                </a>
                <ul class="nav flex-column ms-4 mt-2 slide-toggle {{ $isUjian ? 'show' : '' }}" id="ujianSubmenu">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('admin/ujian/pendaftaran') ? 'active fw-bold text-white' : 'text-white' }}"
                            href="/admin/ujian/pendaftaran">
                            - Seminar Proposal
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('admin/ujian/jadwal') ? 'active fw-bold text-white' : 'text-white' }}"
                            href="/admin/ujian/jadwal">
                            - Sidang Tugas Akhir
                        </a>
                    </li>
                </ul>
            </div>

            @if (auth()->user()->role_id == 1)
                <a class="nav-link {{ Request::is('admin/users') ? 'active fw-bold bg-light text-dark' : '' }}"
                    href="/user">
                    <i class="fas fa-users me-2"></i>Data User
                </a>
            @endif

            <a class="nav-link {{ Request::is('admin/penjadwalan') ? 'active fw-bold bg-light text-dark' : '' }}"
                href="/profile">
                <i class="fas fa-user-alt me-2"></i>Profile
            </a>
            </li>
        </ul>

        <ul class="nav flex-column mt-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </a>
            </li>
        </ul>
    </div>
</nav>
