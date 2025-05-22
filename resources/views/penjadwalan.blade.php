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
                        <h4 class="mb-3">Penjadwalan</h4>
                        <div class="mb-3">
                            <div class="row align-items-center">
                                <div class="col-md-3 col-sm-12">
                                    <h5>Tahun Akademik: </h5>
                                </div>
                                @if (auth()->user()->role_id == 1)
                                    <div class="col-md-3 col-sm-12">
                                        <select class="form-select" id="tahun_akademik" name="tahun_akademik">
                                            <option value="">Tahun Akademik</option>
                                            @foreach ($jadwals as $tahunAkademik)
                                                <option value="{{ $tahunAkademik->tahun_akademik }}">
                                                    {{ $tahunAkademik->tahun_akademik }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 text-end col-sm-12">
                                        <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal"
                                            data-bs-target="#tambahModal">
                                            Tambah
                                        </button>
                                    </div>
                                @else
                                    <div class="col-md-3 col-sm-12">
                                        <h5>2024/2025</h5>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">No</th>
                                        <th style="text-align: center;">Tanggal</th>
                                        <th style="text-align: center;">Jam</th>
                                        <th style="text-align: center;">Tempat</th>
                                        <th>Judul</th>
                                        <th>Mahasiswa</th>
                                        <th>Dosen Pembimbing</th>
                                        @if (auth()->user()->role_id == 3)
                                            <th style="text-align: center;">Ujian</th>
                                        @endif
                                        <th style="text-align: center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jadwals as $jadwal)
                                        <tr>
                                            <td style="text-align: center;">{{ $loop->iteration }}</td>
                                            <td style="text-align: center;">{{ $jadwal->tanggal }}</td>
                                            <td style="text-align: center;">{{ $jadwal->jam }}</td>
                                            <td style="text-align: center;">{{ $jadwal->tempat }}</td>
                                            <td>{{ $jadwal->pengajuan->judul }}</td>
                                            <td>
                                                <div class="">
                                                    {{ $jadwal->pengusul1Jadwal->nama }}
                                                </div>
                                                <div class="">
                                                    {{ $jadwal->pengusul2Jadwal->nama }}
                                                </div>
                                            </td>
                                            <td>{{ $jadwal->dospemJadwal->nama }}</td>
                                            @if (auth()->user()->role_id == 3)
                                                <td style="text-align: center;">{{ $jadwal->jenis_ujian }}</td>
                                            @endif
                                            <td>
                                                {{-- <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#detailModal{{ $user->id }}">
                                                    Detail
                                                </button>
                                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editModal{{ $user->id }}">
                                                    Edit
                                                </button> --}}
                                                {{-- <form action="{{ route('user.delete', $user->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Yakin ingin menghapus?')">
                                                        Hapus
                                                    </button>
                                                </form> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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
