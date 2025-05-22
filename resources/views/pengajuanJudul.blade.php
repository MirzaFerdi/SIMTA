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
                        @php
                            $status = $pengajuanUser->first()->status ?? '';
                            $badgeClass = 'text-bg-secondary';
                            if ($status == 'Diterima') {
                                $badgeClass = 'text-bg-success';
                            } elseif ($status == 'Ditolak') {
                                $badgeClass = 'text-bg-danger';
                            }
                        @endphp
                        <h4 class="mb-3">
                            Pengajuan Judul
                            <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                        </h4>
                        @if (auth()->user()->role_id == 3)
                            <div class="div">
                                <form method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="tahun" class="form-label">Tahun</label>
                                        <input type="text" class="form-control" id="tahun" name="tahun"
                                            placeholder="Masukkan tahun" value="{{ $pengajuanUser->first()->tahun ?? '' }}"
                                            readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="judul" class="form-label">Judul</label>
                                        <input type="text" class="form-control" id="judul" name="judul"
                                            placeholder="Masukkan judul" value="{{ $pengajuanUser->first()->judul ?? '' }}"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="pengusul1" class="form-label">Pengusul 1</label>
                                        <select class="form-select" id="pengusul1" name="pengusul1" required>
                                            <option hidden value="">Pilih Pengusul 1</option>
                                            @foreach ($mahasiswa as $mhs)
                                                <option value="{{ $mhs->id }}"
                                                    {{ $pengajuanUser->first()->pengusul1 == $mhs->id ? 'selected' : '' }}>
                                                    {{ $mhs->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="pengusul2" class="form-label">Pengusul 2</label>
                                        <select class="form-select" id="pengusul2" name="pengusul2" required>
                                            <option hidden value="">Pilih Pengusul 2</option>
                                            @foreach ($mahasiswa as $mhs)
                                                <option value="{{ $mhs->id }}"
                                                    {{ $pengajuanUser->first()->pengusul2 == $mhs->id ? 'selected' : '' }}>
                                                    {{ $mhs->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <button type="button" class="btn btn-secondary">Edit</button>
                                    </div>
                                </form>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">No</th>
                                            <th style="text-align: center;">Tahun</th>
                                            <th>Judul</th>
                                            <th>Pengusul</th>
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
                                                        {{ $pJ->pengusul1Pengajuan->nama }}
                                                    </div>
                                                    <div class="">
                                                        {{ $pJ->pengusul2Pengajuan->nama }}
                                                    </div>
                                                </td>
                                                <td style="text-align: center;">{{ $pJ->status }}</td>
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
