@extends('layouts.main')

@section('content')
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow border-0 rounded-4">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <!-- Detail User -->
                            <div class="col-md-8">
                                <h4 class="mb-3 text-primary">Profil Pengguna</h4>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><strong>Nama:</strong> {{ $user->nama }}</li>
                                    <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
                                    <li class="list-group-item d-flex align-items-center">
                                        <strong class="me-2">Password:</strong>
                                        <span id="password-field" class="me-2" style="letter-spacing:2px;">
                                            <span id="password-text"
                                                style="user-select: all;">{{ $user->decrypted_password }}</span>
                                        </span>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" id="toggle-password"
                                            tabindex="-1">
                                            <i class="bi bi-eye" id="eye-icon"></i>
                                        </button>
                                    </li>
                                    @if ($user->role && $user->role->nama_role === 'admin')
                                        <li class="list-group-item"><strong>NIP:</strong> {{ $user->username }}</li>
                                    @elseif ($user->role && $user->role->nama_role === 'mahasiswa')
                                        <li class="list-group-item"><strong>NIM:</strong> {{ $user->username }}</li>
                                    @endif
                                    <li class="list-group-item"><strong>Prodi:</strong> {{ $user->prodi }}</li>
                                    </li>
                                </ul>
                            </div>

                            <!-- Foto Profil -->
                            <div class="col-md-4 text-center mb-3 mb-md-0">
                                @if ($user->foto)
                                    <img src="{{ asset('storage/foto-profile/' . $user->foto) }}" alt="Foto Profil"
                                        class="rounded shadow" style="width: 150px; height: 225px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('images/default-user.png') }}" alt="Foto Default"
                                        class="rounded shadow" style="width: 150px; height: 225px; object-fit: cover;">
                                @endif
                            </div>

                        </div>
                    </div>

                    <div class="card-footer text-center bg-white">
                        <!-- Tombol buka modal -->
                        <button class="btn btn-outline-primary mt-3" data-bs-toggle="modal"
                            data-bs-target="#editProfileModal">
                            Edit Profil
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal Edit Profil -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title" id="editProfileLabel">Edit Profil</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" name="nama" value="{{ $user->nama }}"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Aktif</label>
                                    <input type="email" class="form-control" name="email" value="{{ $user->email }}"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password Baru
                                        <small class="text-muted">(Kosongkan jika tidak diubah)</small></label>
                                    <input type="password" class="form-control" name="password"
                                        placeholder="Password baru (opsional)">
                                </div>
                                <div class="mb-3">
                                    <label for="foto" class="form-label">Ganti Foto Profil</label>
                                    <input type="file" class="form-control" name="foto">
                                </div>
                            </div>

                            <div class="col-md-4 text-center">
                                <img src="{{ asset('storage/foto-profile/' . $user->foto) }}" class="rounded mb-3"
                                    style="width: 150px; height: 225px; object-fit: cover;" alt="Foto Profil">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordText = document.getElementById('password-text');
            const toggleBtn = document.getElementById('toggle-password');
            const eyeIcon = document.getElementById('eye-icon');
            let isHidden = true;
            const originalPassword = passwordText.textContent;

            function maskPassword(pw) {
                return '•'.repeat(pw.length);
            }
            // Set initial state
            passwordText.textContent = maskPassword(originalPassword);

            toggleBtn.addEventListener('click', function() {
                if (isHidden) {
                    passwordText.textContent = originalPassword;
                    eyeIcon.classList.remove('bi-eye');
                    eyeIcon.classList.add('bi-eye-slash');
                } else {
                    passwordText.textContent = maskPassword(originalPassword);
                    eyeIcon.classList.remove('bi-eye-slash');
                    eyeIcon.classList.add('bi-eye');
                }
                isHidden = !isHidden;
            });
        });
    </script>
@endsection
