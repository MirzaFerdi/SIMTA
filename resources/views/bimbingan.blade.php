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
                        <div class="mb-3 row align-items-center">
                            <div class="col-md-6 col-sm-6 text-start">
                                <h4>Bimbingan</h4>
                            </div>
                            <div class="col-md-6 col-sm-6 text-end">
                                <button type="button" class="btn btn-primary mt-md-0" data-bs-toggle="modal"
                                    data-bs-target="#tambahModal">
                                    Tambah
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">No</th>
                                        <th style="text-align: center;">Tanggal</th>
                                        <th>Topik Bimbingan</th>
                                        <th>Mahasiswa</th>
                                        <th>Dosen Pembimbing</th>
                                        <th style="text-align: center;">Status</th>
                                        <th style="text-align: center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bimbingan as $bim)
                                        <tr>
                                            <td style="text-align: center;">{{ $loop->iteration }}</td>
                                            <td style="text-align: center;">{{ $bim->tanggal }}</td>
                                            <td>{{ $bim->topik_bimbingan }}</td>
                                            <td>
                                                <div class="">
                                                    {{ $bim->pengusul1Bimbingan->nama }}
                                                </div>
                                                <div class="">
                                                    {{ $bim->pengusul2Bimbingan->nama }}
                                                </div>
                                            </td>
                                            <td>{{ $bim->dospemBimbingan->nama }}</td>
                                            <td style="text-align: center;">{{ $bim->status }}</td>
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
