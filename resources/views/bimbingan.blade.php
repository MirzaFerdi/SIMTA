@extends('layouts.main')

@section('content')
@if (session('success'))
<div class="alert alert-success position-absolute top-0 end-0 z-2 alert-dismissible fade show" role="alert"
    id="success-alert">
    <strong>Berhasil!</strong> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if (session('error'))
<div class="alert alert-danger position-absolute top-0 end-0 z-2 alert-dismissible fade show" role="alert"
    id="error-alert">
    <strong>Gagal!</strong> {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if ($errors->any())
<div class="alert alert-danger position-absolute top-0 end-0 z-2 alert-dismissible fade show" role="alert"
    id="error-alert">
    <strong>Gagal!</strong> Silakan periksa inputan Anda.
    <ul class="mt-2 mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="container mt-3">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-4">
                    <div class="mb-3 row align-items-center">
                        <div class="col-md-6 col-sm-6 text-start">
                            <h4>Bimbingan</h4>
                        </div>
                        @if(auth()->user()->role_id == 3)
                        <div class="col-md-6 col-sm-6 text-end">
                            <button type="button" class="btn btn-primary mt-md-0" data-bs-toggle="modal"
                                data-bs-target="#tambahModal">
                                Tambah
                            </button>
                        </div>
                        @endif
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">No</th>
                                    <th style="text-align: center;">Tanggal</th>
                                    <th>Topik Bimbingan</th>
                                    @if (auth()->user()->role_id == 1)
                                    <th>Mahasiswa</th>
                                    @endif
                                    <th>Dosen Pembimbing</th>
                                    <th style="text-align: center;">Status</th>
                                    <th style="text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(auth()->user()->role_id == 3)
                                @foreach ($bimbinganUser as $bim)
                                <tr>
                                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                                    <td style="text-align: center;">{{ $bim->tanggal }}</td>
                                    <td>{{ $bim->topik_bimbingan }}</td>
                                    <td>{{ $bim->dospemBimbingan->nama }}</td>
                                    <td style="text-align: center;">{{ $bim->status }}</td>
                                    <td style="text-align: center;">
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $bim->id }}">
                                            Edit
                                        </button>
                                        <form action="{{ route('bimbingan.delete', $bim->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus bimbingan ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                {{-- Modal Edit --}}
                                <div class="modal fade" id="editModal{{ $bim->id }}" tabindex="-1"
                                    aria-labelledby="editModalLabel{{ $bim->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel{{ $bim->id }}">Edit
                                                    Bimbingan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('bimbingan.update', $bim->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="tanggal" class="form-label">Tanggal</label>
                                                        <input type="date" class="form-control" id="tanggal"
                                                            name="tanggal" value="{{ $bim->tanggal }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="topik_bimbingan" class="form-label">Topik
                                                            Bimbingan</label>
                                                        <textarea class="form-control" id="topik_bimbingan" name="topik_bimbingan" rows="5" required>{{ $bim->topik_bimbingan }}</textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="dospem_id" class="form-label">Dosen
                                                            Pembimbing</label>
                                                        <select class="form-select" id="dospem_id" name="dospem_id"
                                                            required>
                                                            <option hidden value="">Pilih Dosen Pembimbing
                                                            </option>
                                                            @foreach ($dospem as $dos)
                                                            <option value="{{ $dos->id }}"
                                                                {{ $bim->dospem_id == $dos->id ? 'selected' : '' }}>
                                                                {{ $dos->nama }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Simpan
                                                        Perubahan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @elseif(auth()->user()->role_id == 1)
                                @foreach ($bimbingan as $bim)
                                <tr>
                                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                                    <td style="text-align: center;">{{ $bim->tanggal }}</td>
                                    <td>{{ $bim->topik_bimbingan }}</td>
                                    <td>
                                        <div class="">
                                            <ul>
                                                <li>{{ $bim->pengusul1Bimbingan->nama }}</li>
                                                <li>{{ $bim->pengusul2Bimbingan->nama }}</li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td>{{ $bim->dospemBimbingan->nama }}</td>
                                    <td style="text-align: center;">{{ $bim->status }}</td>
                                    <td style="text-align: center;">
                                        <form action="{{ route('bimbingan.updateStatus', $bim->id) }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="Disetujui">
                                            <button type="submit" class="btn btn-success btn-sm"
                                                onclick="return confirm('Apakah Anda yakin ingin menyetujui bimbingan ini?')">
                                                Disetujui
                                            </button>
                                        </form>
                                        <form action="{{ route('bimbingan.updateStatus', $bim->id) }}"
                                            method="POST" enctype="multipart/form-data" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="Ditolak">
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Apakah Anda yakin ingin menolak bimbingan ini?')">
                                                Ditolak
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                        @if(auth()->user()->role_id == 3)
                        <div class="d-flex justify-content-end">
                            <a href="#" class="btn btn-secondary mt-3" target="_blank">Cetak Form Bimbingan</a>
                        </div>
                        @endif
                    </div>
                    {{-- Modal Tambah --}}
                    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="tambahModalLabel">Tambah Bimbingan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('bimbingan.store') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="tanggal" class="form-label">Tanggal</label>
                                            <input type="date" class="form-control" id="tanggal" name="tanggal"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="topik_bimbingan" class="form-label">Topik Bimbingan</label>
                                            <textarea class="form-control" id="topik_bimbingan" name="topik_bimbingan" rows="10" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="dospem_id" class="form-label">Dosen Pembimbing</label>
                                            <select class="form-select" id="dospem_id" name="dospem_id" required>
                                                <option hidden value="">Pilih Dosen Pembimbing</option>
                                                @foreach ($dospem as $dos)
                                                <option value="{{ $dos->id }}">{{ $dos->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Tambah</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
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
@endsection