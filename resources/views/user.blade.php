@extends('layouts.main')

@section('content')
    <!-- Upload Modal -->
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('user.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="uploadModalLabel">Upload User (Excel)</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body bg-light">
                        <div class="mb-3">
                            <label for="file" class="form-label">Pilih file Excel</label>
                            <input type="file" name="file" class="form-control" accept=".xlsx,.xls" required>
                            <small class="text-muted">Format: .xlsx atau .xls</small>
                        </div>
                        <div>
                            <a href="{{ asset('Template Upload User.xlsx') }}" class="text-primary" download>📥 Download
                                Template Excel</a>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="container p-4 mt-3 shadow">
        <div class="d-flex justify-content-between mb-3">
            <h4>Data Mahasiswa</h4>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#uploadModal">
                Upload User (Excel)
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered nowrap" style="width: 100%;" id="myTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mahasiswas as $mahasiswa)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $mahasiswa->username }}</td>
                            <td>{{ $mahasiswa->nama }}</td>
                            <td>{{ $mahasiswa->email }}</td>
                            <td>
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#detailModal{{ $mahasiswa->id }}">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editModal{{ $mahasiswa->id }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <form action="{{ route('user.delete', $mahasiswa->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin ingin menghapus?')">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal{{ $mahasiswa->id }}" tabindex="-1"
                            aria-labelledby="editModalLabel{{ $mahasiswa->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('user.update', $mahasiswa->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel{{ $mahasiswa->id }}">Edit User</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body bg-light">
                                            <div class="mb-3">
                                                <label for="username" class="form-label">NIM</label>
                                                <input type="text" class="form-control" id="username" name="username"
                                                    value="{{ $mahasiswa->username }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="nama" class="form-label">Nama</label>
                                                <input type="text" class="form-control" id="nama" name="nama"
                                                    value="{{ $mahasiswa->nama }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    value="{{ $mahasiswa->email }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="password" class="form-label">Password</label>
                                                <input type="password" class="form-control" id="password"
                                                    name="password"
                                                    placeholder="Kosongkan jika tidak ingin mengubah password">
                                            </div>
                                            <div class="mb-3">
                                                <label for="prodi" class="form-label">Prodi</label>
                                                <input type="text" class="form-control" id="prodi" name="prodi"
                                                    value="{{ $mahasiswa->prodi }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="role_id" class="form-label">Role</label>
                                                <select class="form-select" id="role_id" name="role_id">
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->id }}"
                                                            {{ $mahasiswa->role_id == $role->id ? 'selected' : '' }}>
                                                            {{ $role->nama_role }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Detail Modal -->
                        <div class="modal fade" id="detailModal{{ $mahasiswa->id }}" tabindex="-1"
                            aria-labelledby="detailModalLabel{{ $mahasiswa->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="detailModalLabel{{ $mahasiswa->id }}">Detail User
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body bg-light">
                                        <div class="mb-3">
                                            <label for="username" class="form-label">NIM</label>
                                            <input type="text" class="form-control" id="username" name="username"
                                                value="{{ $mahasiswa->username }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="nama" class="form-label">Nama</label>
                                            <input type="text" class="form-control" id="nama" name="nama"
                                                value="{{ $mahasiswa->nama }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                value="{{ $mahasiswa->email }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control"
                                                    id="password{{ $mahasiswa->id }}"
                                                    value="{{ $mahasiswa->decrypted_password }}" readonly>
                                                <button class="btn btn-outline-secondary" type="button"
                                                    onclick="togglePassword({{ $mahasiswa->id }})">
                                                    <i class="bi bi-eye" id="toggleIcon{{ $mahasiswa->id }}"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="prodi" class="form-label">Prodi</label>
                                            <input type="text" class="form-control" id="prodi" name="prodi"
                                                value="{{ $mahasiswa->prodi }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="role_id" class="form-label">Role</label>
                                            <input type="text" class="form-control" id="role_id" name="role_id"
                                                value="{{ $mahasiswa->role->nama_role }}" readonly>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="container p-4 mt-3 shadow">
        <h4>Data Dosen</h4>
        <div class="table-responsive">
            <table class="table table-bordered nowrap" style="width: 100%;" id="myTable2">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dosens as $dosen)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $dosen->username }}</td>
                            <td>{{ $dosen->nama }}</td>
                            <td>{{ $dosen->email }}</td>
                            <td>
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#detailModal{{ $dosen->id }}">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editModal{{ $dosen->id }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <form action="{{ route('user.delete', $dosen->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin ingin menghapus?')">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal{{ $dosen->id }}" tabindex="-1"
                            aria-labelledby="editModalLabel{{ $dosen->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('user.update', $dosen->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel{{ $dosen->id }}">Edit User</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body bg-light">
                                            <div class="mb-3">
                                                <label for="username" class="form-label">NIM</label>
                                                <input type="text" class="form-control" id="username"
                                                    name="username" value="{{ $dosen->username }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="nama" class="form-label">Nama</label>
                                                <input type="text" class="form-control" id="nama" name="nama"
                                                    value="{{ $dosen->nama }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    value="{{ $dosen->email }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="password" class="form-label">Password</label>
                                                <input type="password" class="form-control" id="password"
                                                    name="password"
                                                    placeholder="Kosongkan jika tidak ingin mengubah password">
                                            </div>
                                            <div class="mb-3">
                                                <label for="prodi" class="form-label">Prodi</label>
                                                <input type="text" class="form-control" id="prodi" name="prodi"
                                                    value="{{ $dosen->prodi }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="role_id" class="form-label">Role</label>
                                                <select class="form-select" id="role_id" name="role_id">
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->id }}"
                                                            {{ $dosen->role_id == $role->id ? 'selected' : '' }}>
                                                            {{ $role->nama_role }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Detail Modal -->
                        <div class="modal fade" id="detailModal{{ $dosen->id }}" tabindex="-1"
                            aria-labelledby="detailModalLabel{{ $dosen->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="detailModalLabel{{ $dosen->id }}">Detail User</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body bg-light">
                                        <div class="mb-3">
                                            <label for="username" class="form-label">NIM</label>
                                            <input type="text" class="form-control" id="username" name="username"
                                                value="{{ $dosen->username }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="nama" class="form-label">Nama</label>
                                            <input type="text" class="form-control" id="nama" name="nama"
                                                value="{{ $dosen->nama }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                value="{{ $dosen->email }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control"
                                                    id="password{{ $dosen->id }}"
                                                    value="{{ $dosen->decrypted_password }}" readonly>
                                                <button class="btn btn-outline-secondary" type="button"
                                                    onclick="togglePassword({{ $dosen->id }})">
                                                    <i class="bi bi-eye" id="toggleIcon{{ $dosen->id }}"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="prodi" class="form-label">Prodi</label>
                                            <input type="text" class="form-control" id="prodi" name="prodi"
                                                value="{{ $dosen->prodi }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="role_id" class="form-label">Role</label>
                                            <input type="text" class="form-control" id="role_id" name="role_id"
                                                value="{{ $dosen->role->nama_role }}" readonly>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function togglePassword(userId) {
            const input = document.getElementById('password' + userId);
            const icon = document.getElementById('toggleIcon' + userId);

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                "language": {
                    "search": "Cari:",
                    "lengthMenu": "Tampilkan _MENU_ entri",
                    "info": "Menampilkan _START_ hingga _END_ dari _TOTAL_ entri",
                    "infoEmpty": "Tidak ada entri yang ditemukan",
                    "zeroRecords": "Tidak ada entri yang cocok",
                    "paginate": {
                        "previous": "Sebelumnya",
                        "next": "Selanjutnya"
                    }
                },
                scrollX: true,
                stripeClasses: ['table-primary', 'table-light'],
            });

        });
        $(document).ready(function() {
            $('#myTable2').DataTable({
                "language": {
                    "search": "Cari:",
                    "lengthMenu": "Tampilkan _MENU_ entri",
                    "info": "Menampilkan _START_ hingga _END_ dari _TOTAL_ entri",
                    "infoEmpty": "Tidak ada entri yang ditemukan",
                    "zeroRecords": "Tidak ada entri yang cocok",
                    "paginate": {
                        "previous": "Sebelumnya",
                        "next": "Selanjutnya"
                    }
                },
                scrollX: true,
                stripeClasses: ['table-primary', 'table-light'],
            });
        });
    </script>
@endsection
