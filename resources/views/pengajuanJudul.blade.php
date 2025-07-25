@extends('layouts.main')

@section('content')
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card  shadow border-0 rounded-4">
                    <div class="card-body p-4">
                        <h4 class="mb-3">
                            Pengajuan Judul
                        </h4>
                        @if (auth()->user()->role_id == 3)
                            @if ($bolehTambah)
                                <button class="btn btn-primary mb-3" data-bs-toggle="modal"
                                    data-bs-target="#tambahModal">Tambah
                                    Pengajuan</button>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-bordered " style="width: 100%" id="myTable">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">No</th>
                                            <th style="text-align: center;">Tahun</th>
                                            <th>Judul</th>
                                            <th>mahasiswa</th>
                                            <th>Dospem</th>
                                            <th style="text-align: center;">Status</th>
                                            <th style="text-align: center;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pengajuanJudul as $pJ)
                                            <tr>
                                                <td style="text-align: center;">{{ $loop->iteration }}</td>
                                                <td style="text-align: center;">{{ $pJ->tahun }}</td>
                                                <td>{{ $pJ->judul }}</td>
                                                <td>
                                                    <div class="">
                                                        <ul>
                                                            <li>{{ $pJ->mahasiswa1Pengajuan->nama }}</li>
                                                            <li>{{ $pJ->mahasiswa2Pengajuan->nama }}</li>
                                                        </ul>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if ($pJ->dospem1)
                                                        {{ $pJ->dospem1Pengajuan->nama }}
                                                    @else
                                                        -
                                                    @endif
                                                    <br>
                                                    @if ($pJ->dospem2)
                                                        {{ $pJ->dospem2Pengajuan->nama }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td style="text-align: center;">
                                                    @if ($pJ->status == 'Disetujui')
                                                        <span class="badge bg-success">{{ $pJ->status }}</span>
                                                    @elseif ($pJ->status == 'Ditolak')
                                                        <span class="badge bg-danger">{{ $pJ->status }}</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ $pJ->status }}</span>
                                                    @endif
                                                </td>
                                                <td style="text-align: center;">
                                                    @if (auth()->user()->role_id == 3 &&
                                                            $pJ->status !== 'Disetujui' &&
                                                            (auth()->user()->id == $pJ->mahasiswa1 || auth()->user()->id == $pJ->mahasiswa2))
                                                        <button class="btn btn-primary btn-sm"
                                                            id="editBtn-{{ $pJ->id }}" data-bs-toggle="modal"
                                                            data-bs-target="#editModal-{{ $pJ->id }}">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </button>
                                                        <form action="{{ route('pengajuan.delete', $pJ->id) }}"
                                                            method="POST" class="d-inline"
                                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus Judul ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm"><i
                                                                    class="fa-solid fa-trash-can"></i></button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                            {{-- Modal Edit Pengajuan --}}
                                            <div class="modal fade" id="editModal-{{ $pJ->id }}" tabindex="-1"
                                                aria-labelledby="editModalLabel-{{ $pJ->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="editModalLabel-{{ $pJ->id }}">Edit Pengajuan
                                                                Judul</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('pengajuan.update', $pJ->id) }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="_method"
                                                                id="form-method-{{ $pJ->id }}" value="">
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="tahun-{{ $pJ->id }}"
                                                                        class="form-label">Tahun</label>
                                                                    <input type="text" class="form-control"
                                                                        id="tahun-{{ $pJ->id }}" name="tahun"
                                                                        value="{{ $pJ->tahun }}" disabled>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="judul-{{ $pJ->id }}"
                                                                        class="form-label">Judul</label>
                                                                    <input type="text" class="form-control"
                                                                        id="judul-{{ $pJ->id }}" name="judul"
                                                                        value="{{ $pJ->judul }}" disabled>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="mahasiswa1-{{ $pJ->id }}"
                                                                        class="form-label">mahasiswa 1</label>
                                                                    <select class="form-select"
                                                                        id="mahasiswa1-{{ $pJ->id }}"
                                                                        name="mahasiswa1" disabled>
                                                                        <option value="">Pilih mahasiswa 1</option>
                                                                        @foreach ($mahasiswa as $mhs)
                                                                            <option value="{{ $mhs->id }}"
                                                                                {{ $mhs->id == $pJ->mahasiswa1 ? 'selected' : '' }}>
                                                                                {{ $mhs->nama }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="mahasiswa2-{{ $pJ->id }}"
                                                                        class="form-label">mahasiswa 2</label>
                                                                    <select class="form-select"
                                                                        id="mahasiswa2-{{ $pJ->id }}"
                                                                        name="mahasiswa2" disabled>
                                                                        <option value="">Pilih mahasiswa 2</option>
                                                                        @foreach ($mahasiswa as $mhs)
                                                                            <option value="{{ $mhs->id }}"
                                                                                {{ $mhs->id == $pJ->mahasiswa2 ? 'selected' : '' }}>
                                                                                {{ $mhs->nama }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="dospem1-{{ $pJ->id }}"
                                                                        class="form-label">Dosen Pembimbing 1</label>
                                                                    <select class="form-select"
                                                                        id="dospem1-{{ $pJ->id }}" name="dospem1">
                                                                        <option value="">Pilih Dosen Pembimbing 1
                                                                        </option>
                                                                        @foreach ($dosen as $dsn)
                                                                            <option value="{{ $dsn->id }}"
                                                                                {{ $dsn->id == $pJ->dospem1 ? 'selected' : '' }}>
                                                                                {{ $dsn->nama }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="dospem2-{{ $pJ->id }}"
                                                                        class="form-label">Dosen Pembimbing 2</label>
                                                                    <select class="form-select"
                                                                        id="dospem2-{{ $pJ->id }}" name="dospem2">
                                                                        <option value="">Pilih Dosen Pembimbing 2
                                                                        </option>
                                                                        @foreach ($dosen as $dsn)
                                                                            <option value="{{ $dsn->id }}"
                                                                                {{ $dsn->id == $pJ->dospem2 ? 'selected' : '' }}>
                                                                                {{ $dsn->nama }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    <small class="text-muted">
                                                                        Jika tidak ada Dosen Pembimbing 2, biarkan
                                                                        kosong.
                                                                    </small>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Tutup</button>
                                                                <button type="button" class="btn btn-primary"
                                                                    id="editBtn-{{ $pJ->id }}">Edit</button>
                                                                <button type="submit" class="btn btn-success d-none"
                                                                    id="updateBtn-{{ $pJ->id }}">Update</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{-- Modal Tambah Pengajuan --}}
                            <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="tambahModalLabel">Tambah Pengajuan Judul</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('pengajuan.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="tahun" class="form-label">Tahun</label>
                                                    <input type="text" class="form-control" id="tahun"
                                                        name="tahun" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="judul" class="form-label">Judul</label>
                                                    <input type="text" class="form-control" id="judul"
                                                        name="judul" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="mahasiswa1" class="form-label">mahasiswa 1</label>
                                                    <select class="form-select" id="mahasiswa1" name="mahasiswa1"
                                                        required>
                                                        <option hidden value="">Pilih mahasiswa 1</option>
                                                        @foreach ($mahasiswa as $mhs)
                                                            <option value="{{ $mhs->id }}">{{ $mhs->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="mahasiswa2" class="form-label">mahasiswa 2</label>
                                                    <select class="form-select" id="mahasiswa2" name="mahasiswa2"
                                                        required>
                                                        <option hidden value="">Pilih mahasiswa 2</option>
                                                        @foreach ($mahasiswa as $mhs)
                                                            <option value="{{ $mhs->id }}">{{ $mhs->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="dospem1" class="form-label">Dosen Pembimbing 1</label>
                                                    <select class="form-select" id="dospem1" name="dospem1" required>
                                                        <option hidden value="">Pilih Dosen Pembimbing 1</option>
                                                        @foreach ($dosen as $dsn)
                                                            <option value="{{ $dsn->id }}">{{ $dsn->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="dospem2" class="form-label">Dosen Pembimbing 2</label>
                                                    <select class="form-select" id="dospem2" name="dospem2">
                                                        <option hidden value="">Pilih Dosen Pembimbing 2</option>
                                                        @foreach ($dosen as $dsn)
                                                            <option value="{{ $dsn->id }}">{{ $dsn->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <small class="text-muted">
                                                        Jika tidak ada Dosen Pembimbing 2, biarkan
                                                        kosong.
                                                    </small>
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
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered" style="width: 100%" id="myTable">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">No</th>
                                            <th style="text-align: center;">Tahun</th>
                                            <th>Judul</th>
                                            <th>mahasiswa</th>
                                            <th>Dospem</th>
                                            <th style="text-align: center;">Status</th>
                                            <th style="text-align: center;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pengajuanJudul as $pJ)
                                            <tr>
                                                <td style="text-align: center;">{{ $loop->iteration }}</td>
                                                <td style="text-align: center;">{{ $pJ->tahun }}</td>
                                                <td>{{ $pJ->judul }}</td>
                                                <td>
                                                    <div class="">
                                                        <ul>
                                                            <li>{{ $pJ->mahasiswa1Pengajuan->nama }}</li>
                                                            <li>{{ $pJ->mahasiswa2Pengajuan->nama }}</li>
                                                        </ul>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if ($pJ->dospem1)
                                                        {{ $pJ->dospem1Pengajuan->nama }}
                                                    @else
                                                        -
                                                    @endif
                                                    <br>
                                                    @if ($pJ->dospem2)
                                                        {{ $pJ->dospem2Pengajuan->nama }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td style="text-align: center;">
                                                    @if ($pJ->status == 'Disetujui')
                                                        <span class="badge bg-success">{{ $pJ->status }}</span>
                                                    @elseif ($pJ->status == 'Ditolak')
                                                        <span class="badge bg-danger">{{ $pJ->status }}</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ $pJ->status }}</span>
                                                    @endif
                                                </td>
                                                <td style="text-align: center;">
                                                    @if ($pJ->dospem1 == auth()->user()->id || $pJ->dospem2 == auth()->user()->id)
                                                        <form action="{{ route('pengajuan.updateStatus', $pJ->id) }}"
                                                            method="POST" enctype="multipart/form-data"
                                                            class="d-inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="Disetujui">
                                                            <button type="submit" class="btn btn-success btn-sm"
                                                                onclick="return confirm('Apakah Anda yakin ingin menyetujui Judul ini?')">
                                                                Disetujui
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('pengajuan.updateStatus', $pJ->id) }}"
                                                            method="POST" enctype="multipart/form-data"
                                                            class="d-inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="Ditolak">
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Apakah Anda yakin ingin menolak Judul ini?')">
                                                                Ditolak
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                        <div class="text-center">
                            {{-- <button type="submit" class="btn btn-primary">Jadwalkan</button> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Untuk setiap tombol edit pada modal
            @foreach ($pengajuanJudul as $pJ)
                const editBtn{{ $pJ->id }} = document.getElementById('editBtn-{{ $pJ->id }}');
                const updateBtn{{ $pJ->id }} = document.getElementById('updateBtn-{{ $pJ->id }}');
                const formMethodInput{{ $pJ->id }} = document.getElementById(
                    'form-method-{{ $pJ->id }}');

                if (editBtn{{ $pJ->id }}) {
                    editBtn{{ $pJ->id }}.addEventListener('click', function() {
                        if (confirm('Edit akan mengubah status menjadi Diproses. Lanjutkan?')) {
                            document.getElementById('tahun-{{ $pJ->id }}')?.removeAttribute(
                                'disabled');
                            document.getElementById('judul-{{ $pJ->id }}')?.removeAttribute(
                                'disabled');
                            document.getElementById('mahasiswa1-{{ $pJ->id }}')?.removeAttribute(
                                'disabled');
                            document.getElementById('mahasiswa2-{{ $pJ->id }}')?.removeAttribute(
                                'disabled');
                            document.getElementById('dospem1-{{ $pJ->id }}')?.removeAttribute(
                                'disabled');
                            document.getElementById('dospem2-{{ $pJ->id }}')?.removeAttribute(
                                'disabled');

                            // Ubah badge status pada modal jika ada
                            const modal = document.getElementById('editModal-{{ $pJ->id }}');
                            if (modal) {
                                const badge = modal.querySelector('.badge');
                                if (badge) {
                                    badge.textContent = 'Diproses';
                                    badge.className = 'badge text-bg-secondary';
                                }
                            }

                            if (formMethodInput{{ $pJ->id }}) {
                                formMethodInput{{ $pJ->id }}.value = 'PUT';
                            }

                            editBtn{{ $pJ->id }}.classList.add('d-none');
                            updateBtn{{ $pJ->id }}.classList.remove('d-none');
                        }
                    });
                }
            @endforeach
        });

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
