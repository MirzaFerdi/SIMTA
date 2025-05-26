@extends('layouts.main')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
            <strong>Berhasil!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error-alert">
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
                        <h4 class="mb-3">Seminar Proposal</h4>
                        @if (auth()->user()->role_id == 1)
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">No</th>
                                            <th>Nama Mahasiswa</th>
                                            <th>Judul</th>
                                            <th>File</th>
                                            <th style="text-align: center;">Status</th>
                                            <th style="text-align: center;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sempros as $sempro)
                                            <tr>
                                                <td style="text-align: center;">{{ $loop->iteration }}</td>
                                                <td>
                                                    <div class="">
                                                        {{ $sempro->pengusul1Sempro->nama }}
                                                    </div>
                                                    <div class="">
                                                        {{ $sempro->pengusul2Sempro->nama }}
                                                    </div>
                                                </td>
                                                <td>{{ $sempro->pengajuanSempro->judul }}</td>
                                                <td>
                                                    <div class="">
                                                        {{ $sempro->laporan }}
                                                    </div>
                                                    <div class="">
                                                        {{ $sempro->berita_acara }}
                                                    </div>
                                                    <div class="">
                                                        {{ $sempro->ppt }}
                                                    </div>
                                                </td>
                                                <td style="text-align: center;">{{ $sempro->status }}</td>
                                                <td style="text-align: center;">
                                                    <form action="{{ route('sempro.updateStatus', $sempro->id) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="Disetujui">
                                                        <button type="submit" class="btn btn-success btn-sm"
                                                            onclick="return confirm('Apakah Anda yakin ingin menerima seminar proposal ini?')">Terima</button>
                                                    </form>
                                                    <form action="{{ route('sempro.updateStatus', $sempro->id) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="Ditolak">
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Apakah Anda yakin ingin menolak seminar proposal ini?')">Tolak</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="mb-2 d-flex align-items-center">
                                <div style="width: 220px;">Template Laporan Proposal:</div>
                                <a href="{{ asset('storage/template/Template_Laporan_Proposal.docx') }}"
                                    class="btn btn-primary btn-sm" target="_blank">Download</a>
                            </div>
                            <div class="mb-2 d-flex align-items-center">
                                <div style="width: 220px;">Berita Acara:</div>
                                <a href="{{ asset('storage/template/Template_Berita_Acara_Seminar_Proposal.docx') }}"
                                    class="btn btn-primary btn-sm" target="_blank">Download</a>
                            </div>
                            <hr>
                            <h5>Detail Proposal</h5>
                            <div class="">
                                <form action="" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="no_ta" class="form-label">No. TA</label>
                                        <input type="text" class="form-control" id="no_ta" name="no_ta"
                                            value="{{ $semproUser->first()->no_ta ?? '' }}"
                                            @if (empty($semproUser->first()->no_ta)) required @else  disabled @endif>
                                    </div>
                                    <div class="mb-3">
                                        <label for="pengusul" class="form-label">Pengusul1</label>
                                        <select class="form-select" id="pengusul1" name="pengusul1"
                                            @if (empty($semproUser->first()->pengusul1)) required @else disabled @endif>
                                            <option hidden value="">Pilih Pengusul 1</option>
                                            @foreach ($mahasiswas as $mahasiswa)
                                                <option value="{{ $mahasiswa->id }}"
                                                    {{ optional($semproUser->first())->pengusul1 == $mahasiswa->id ? 'selected' : '' }}>
                                                    {{ $mahasiswa->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="pengusul2" class="form-label">Pengusul2</label>
                                        <select class="form-select" id="pengusul2" name="pengusul2"
                                            @if (empty($semproUser->first()->pengusul2)) required @else disabled @endif>
                                            <option hidden value="">Pilih Pengusul 2</option>
                                            @foreach ($mahasiswas as $mahasiswa)
                                                <option value="{{ $mahasiswa->id }}"
                                                    {{ optional($semproUser->first())->pengusul2 == $mahasiswa->id ? 'selected' : '' }}>
                                                    {{ $mahasiswa->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="dospem" class="form-label">Dosen Pembimbing</label>
                                        <select class="form-select" id="dospem" name="dospem"
                                            @if ( empty($semproUser->first()->dospem_id)) required @else disabled @endif>
                                            <option hidden value="">Pilih Dosen Pembimbing</option>
                                            @foreach ($dospem as $d)
                                                <option value="{{ $d->id }}"
                                                    {{ optional($semproUser->first())->dospem_id == $d->id ? 'selected' : '' }}>
                                                    {{ $d->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="judul" class="form-label">Judul</label>
                                        <input type="text" class="form-control" id="judul" name="judul"
                                            value="{{ $pengajuan->first()->judul ?? '' }}"
                                            @if(empty($pengajuan->first()->judul)) required @else disabled @endif>
                                    </div>
                                    <div class="mb-3">
                                        <label for="abstrak" class="form-label">Abstrak/Deskripsi</label>
                                        <textarea class="form-control" id="abstrak" name="abstrak" rows="5"
                                        @if (empty($semproUser->first()->abstrak)) required @else disabled @endif>{{ $semproUser->first()->abstrak ?? '' }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="laporan" class="form-label">Laporan</label>
                                        <input type="file" class="form-control" id="laporan" name="laporan"
                                            accept=".docx,.pdf" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="ppt" class="form-label">PPT</label>
                                        <input type="file" class="form-control" id="ppt" name="ppt"
                                            accept=".ppt,.pptx" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="berita_acara" class="form-label">Berita Acara</label>
                                        <input type="file" class="form-control" id="berita_acara" name="berita_acara"
                                            accept=".docx,.pdf" required>
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary">
                                            Simpan
                                        </button>
                                        <button type="button" class="btn btn-secondary">
                                            Edit
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif
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
                alert.classList.remove('show');
                alert.classList.add('fade');
            }
        }, 3000);

        setTimeout(function() {
            var alert = document.getElementById('error-alert');
            if (alert) {
                alert.classList.remove('show');
                alert.classList.add('fade');
            }
        }, 3000);
    </script>
@endsection
