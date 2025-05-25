@extends('layouts.main')

@section('content')
    @if (session('success'))
        <div class="alert position-absolute top-0 end-0 z-2 alert-success alert-dismissible fade show" role="alert"
            id="success-alert">
            <strong>Berhasil!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert position-absolute top-0 end-0 z-2 alert-danger alert-dismissible fade show" role="alert"
            id="error-alert">
            <strong>Gagal!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert position-absolute top-0 end-0 z-2 alert-danger alert-dismissible fade show" role="alert"
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
                <div class="card  shadow border-0 rounded-4">
                    <div class="card-body p-4">
                        @php
                            $status = $pengajuanUser->first()->status ?? 'Belum Diajukan';
                            $badgeClass = 'text-bg-secondary';
                            if ($status == 'Diterima') {
                                $badgeClass = 'text-bg-success';
                            } elseif ($status == 'Ditolak') {
                                $badgeClass = 'text-bg-danger';
                            }
                        @endphp
                        <h4 class="mb-3">
                            Pengajuan Judul
                            @if (auth()->user()->role_id == 3)
                                <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                            @endif
                        </h4>
                        @if (auth()->user()->role_id == 3)
                            <div class="div">
                                <form method="POST" action="{{ route('pengajuan.store') }}">
                                    @csrf
                                    <input type="hidden" name="_method" id="form-method" value="POST">
                                    <div class="mb-3">
                                        @php

                                        @endphp
                                        <label for="tahun" class="form-label">Tahun</label>
                                        <input type="text" class="form-control" id="tahun" name="tahun"
                                            placeholder="Masukkan tahun" value="{{ $pengajuanUser->first()->tahun ?? '' }}"
                                            @if (empty($pengajuanUser->first()->tahun)) required @else disabled @endif>
                                    </div>
                                    <div class="mb-3">
                                        <label for="judul" class="form-label">Judul</label>
                                        <input type="text" class="form-control" id="judul" name="judul"
                                            placeholder="Masukkan judul" value="{{ $pengajuanUser->first()->judul ?? '' }}"
                                            @if (empty($pengajuanUser->first()->judul)) required @else disabled @endif>
                                    </div>
                                    <div class="mb-3">
                                        <label for="pengusul1" class="form-label">Pengusul 1</label>
                                        <select class="form-select" id="pengusul1" name="pengusul1"
                                            @if (empty($pengajuanUser->first()->pengusul1)) required @else disabled @endif>
                                            <option hidden value="">Pilih Pengusul 1</option>
                                            @foreach ($mahasiswa as $mhs)
                                                <option value="{{ $mhs->id }}"
                                                    {{ optional($pengajuanUser->first())->pengusul1 == $mhs->id ? 'selected' : '' }}>
                                                    {{ $mhs->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="pengusul2" class="form-label">Pengusul 2</label>
                                        <select class="form-select" id="pengusul2" name="pengusul2"
                                            @if (empty($pengajuanUser->first()->pengusul2)) required @else disabled @endif>
                                            <option hidden value="">Pilih Pengusul 2</option>
                                            @foreach ($mahasiswa as $mhs)
                                                <option value="{{ $mhs->id }}"
                                                    {{ optional($pengajuanUser->first())->pengusul2 == $mhs->id ? 'selected' : '' }}>
                                                    {{ $mhs->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <button type="button" class="btn btn-secondary" id="editBtn">Edit</button>
                                        @if ($pengajuanUser->first())
                                            @method('PUT')
                                        @endif
                                        <button type="submit" class="btn btn-success d-none" id="updateBtn"
                                            formaction="{{ route('pengajuan.update', $pengajuanUser->first()->id ?? 0) }}">Update</button>
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                const editBtn = document.getElementById('editBtn');
                                                const updateBtn = document.getElementById('updateBtn');
                                                const formMethodInput = document.getElementById('form-method');

                                                editBtn?.addEventListener('click', function() {
                                                    if (confirm('Edit akan mengubah status menjadi Diproses. Lanjutkan?')) {
                                                        // Enable all disabled inputs
                                                        document.getElementById('tahun')?.removeAttribute('disabled');
                                                        document.getElementById('judul')?.removeAttribute('disabled');
                                                        document.getElementById('pengusul1')?.removeAttribute('disabled');
                                                        document.getElementById('pengusul2')?.removeAttribute('disabled');

                                                        // Change status badge text and class
                                                        const badge = document.querySelector('.badge');
                                                        if (badge) {
                                                            badge.textContent = 'Diproses';
                                                            badge.className = 'badge text-bg-secondary';
                                                        }

                                                        // Set form method to PUT
                                                        formMethodInput.value = 'PUT';

                                                        // Hide Edit, show Update
                                                        editBtn.classList.add('d-none');
                                                        updateBtn.classList.remove('d-none');
                                                    }
                                                });
                                            });
                                        </script>
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
                                                        <ul>
                                                            <li>{{ $pJ->pengusul1Pengajuan->nama }}</li>
                                                            <li>{{ $pJ->pengusul2Pengajuan->nama }}</li>
                                                        </ul>
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
