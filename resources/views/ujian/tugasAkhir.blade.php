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
                        <h4 class="mb-3">Tugas Akhir</h4>
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
                                        @foreach ($tugasAkhir as $TA)
                                            <tr>
                                                <td style="text-align: center;">{{ $loop->iteration }}</td>
                                                <td>
                                                    <div class="">
                                                        {{ $TA->pengusul1TugasAkhir->nama }}
                                                    </div>
                                                    <div class="">
                                                        {{ $TA->pengusul2TugasAkhir->nama }}
                                                    </div>
                                                </td>
                                                <td>{{ $TA->pengajuanTugasAkhir->judul }}</td>
                                                <td>
                                                    <div class="">
                                                        {{ $TA->laporan }}
                                                    </div>
                                                    <div class="">
                                                        {{ $TA->berita_acara }}
                                                    </div>
                                                    <div class="">
                                                        {{ $TA->ppt }}
                                                    </div>
                                                    <div class="">
                                                        {{ $TA->bimbingan }}
                                                    </div>
                                                </td>
                                                <td style="text-align: center;">{{ $TA->status }}</td>
                                                <td style="text-align: center;">
                                                    <form action="{{ route('tugas-akhir.updateStatus', $TA->id) }}" method="POST"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="Disetujui">
                                                        <button type="submit" class="btn btn-success btn-sm"
                                                            onclick="return confirm('Apakah Anda yakin ingin menyetujui tugas akhir ini?')">
                                                            Setujui
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('tugas-akhir.updateStatus', $TA->id) }}" method="POST"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="Ditolak">
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Apakah Anda yakin ingin menolak tugas akhir ini?')">
                                                            Tolak
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
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
