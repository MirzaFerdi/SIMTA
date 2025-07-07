@extends('layouts.main')

@section('content')
    <div class="container p-4 mt-3 shadow">
        <div class="d-flex justify-content-between mb-4">
            <h4 class="mb-3">Berita Acara</h4>
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahBeritaAcaraModal">
                <i class="bi bi-plus"></i> Tambah Berita Acara
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered nowrap" style="width: 100%;" id="myTable">
                <thead>
                    <tr>
                        <th style="text-align: center;">No</th>
                        <th>Nama Mahasiswa</th>
                        <th>Nama Dosen</th>
                        <th>Judul TA</th>
                        <th>Berita Acara</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($beritaAcara as $ba)
                        <tr>
                            <td style="text-align: center;">{{ $loop->iteration }}</td>
                            <td>
                                <div class="">
                                    {{ $ba->mahasiswa1BeritaAcara->nama }}
                                </div>
                                <div class="">
                                    {{ $ba->mahasiswa2BeritaAcara->nama }}
                                </div>
                            </td>
                            <td>{{ $ba->dosenBeritaAcara->nama }}</td>
                            <td>{{ $ba->pengajuanBeritaAcara->judul }}</td>
                            <td>
                                <a href="{{ asset('storage/file/berita-acara/' . $ba->berita_acara) }}" target="_blank"
                                    class="text-decoration-none">
                                    <i class="bi bi-file-earmark"></i>
                                    {{ pathinfo($ba->berita_acara, PATHINFO_FILENAME) }}
                                </a>
                            </td>
                            <td style="text-align: center;">
                                <form action="{{ route('berita-acara.destroy', $ba->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus berita acara ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editBeritaAcaraModal{{ $ba->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                            </td>
                        </tr>

                        {{-- Modal Edit --}}
                        <div class="modal fade" id="editBeritaAcaraModal{{ $ba->id }}" tabindex="-1"
                            aria-labelledby="editBeritaAcaraModalLabel{{ $ba->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editBeritaAcaraModalLabel{{ $ba->id }}">Edit
                                            Berita Acara</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('berita-acara.update', $ba->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="mahasiswa1" class="form-label">mahasiswa 1</label>
                                                <select class="form-select" name="mahasiswa1" id="mahasiswa1" required>
                                                    <option value="" hidden selected>Pilih mahasiswa 1</option>
                                                    @foreach ($mahasiswa as $mhs)
                                                        <option value="{{ $mhs->id }}"
                                                            {{ $mhs->id == $ba->mahasiswa1 ? 'selected' : '' }}>
                                                            {{ $mhs->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="mahasiswa2" class="form-label">mahasiswa 2</label>
                                                <select class="form-select" name="mahasiswa2" id="mahasiswa2" required>
                                                    <option value="" hidden selected>Pilih mahasiswa 2</option>
                                                    @foreach ($mahasiswa as $mhs)
                                                        <option value="{{ $mhs->id }}"
                                                            {{ $mhs->id == $ba->mahasiswa2 ? 'selected' : '' }}>
                                                            {{ $mhs->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="dosen" class="form-label">Dosen Pembimbing</label>
                                                <select class="form-select" name="dosen" id="dosen" required>
                                                    <option value="" hidden selected>Pilih Dosen Pembimbing</option>
                                                    @foreach ($dosen as $dsn)
                                                        <option value="{{ $dsn->id }}"
                                                            {{ $dsn->id == $ba->dosen ? 'selected' : '' }}>
                                                            {{ $dsn->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="pengajuan_id" class="form-label">Judul Tugas Akhir</label>
                                                <select class="form-select" name="pengajuan_id" id="pengajuan_id" required>
                                                    <option value="" hidden selected>Pilih Judul Tugas Akhir</option>
                                                    @foreach ($pengajuan as $pj)
                                                        <option value="{{ $pj->id }}"
                                                            {{ $pj->id == $ba->pengajuan_id ? 'selected' : '' }}>
                                                            {{ $pj->judul }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="berita_acara" class="form-label">Berita Acara</label>
                                                <input type="file" class="form-control" name="berita_acara"
                                                    id="berita_acara" accept=".pdf,.docx,.doc">
                                                <small class="text-muted">Kosongkan jika tidak ingin mengubah
                                                    berkas berita acara</small>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Tambah --}}
    <div class="modal fade" id="tambahBeritaAcaraModal" tabindex="-1" aria-labelledby="tambahBeritaAcaraModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahBeritaAcaraModalLabel">Tambah Berita Acara</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('berita-acara.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="mahasiswa1" class="form-label">mahasiswa 1</label>
                            <select class="form-select" name="mahasiswa1" id="mahasiswa1" required>
                                <option value="" hidden selected>Pilih mahasiswa 1</option>
                                @foreach ($mahasiswa as $mhs)
                                    <option value="{{ $mhs->id }}">{{ $mhs->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="mahasiswa2" class="form-label">mahasiswa 2</label>
                            <select class="form-select" name="mahasiswa2" id="mahasiswa2" required>
                                <option value="" hidden selected>Pilih mahasiswa 2</option>
                                @foreach ($mahasiswa as $mhs)
                                    <option value="{{ $mhs->id }}">{{ $mhs->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="dosen" class="form-label">Dosen Pembimbing</label>
                            <select class="form-select" name="dosen" id="dosen" required>
                                <option value="" hidden selected>Pilih Dosen Pembimbing</option>
                                @foreach ($dosen as $dsn)
                                    <option value="{{ $dsn->id }}">{{ $dsn->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="pengajuan_id" class="form-label">Judul Tugas Akhir</label>
                            <select class="form-select" name="pengajuan_id" id="pengajuan_id" required>
                                <option value="" hidden selected>Pilih Judul Tugas Akhir</option>
                                @foreach ($pengajuan as $pj)
                                    <option value="{{ $pj->id }}">{{ $pj->judul }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="berita_acara" class="form-label">Berita Acara</label>
                            <input type="file" class="form-control" name="berita_acara" id="berita_acara"
                                accept=".pdf,.docx,.doc" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
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
    </script>
@endsection
