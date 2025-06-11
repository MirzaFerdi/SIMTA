@extends('layouts.main')

@section('content')
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow border-0 rounded-4">
                    <div class="card-body p-4">
                        <h4 class="mb-3">Seminar Proposal</h4>
                        @if (auth()->user()->role_id == 2)
                            <div class="table-responsive">
                                <table class="table table-bordered" style="width: 100%" id="myTable">
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
                                                        <a href="{{ asset('storage/file/laporan/' . $sempro->laporan) }}"
                                                            target="_blank"
                                                            class="btn btn-link text-decoration-none">{{ $sempro->laporan }}</a>
                                                    </div>
                                                    {{-- <div class="">
                                                        {{ $sempro->berita_acara }}
                                                    </div> --}}
                                                    <div class="">
                                                        <a href="{{ asset('storage/file/ppt/' . $sempro->ppt) }}"
                                                            target="_blank"
                                                            class="btn btn-link text-decoration-none">{{ $sempro->ppt }}</a>
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
                                                            onclick="return confirm('Apakah Anda yakin ingin menerima seminar proposal ini?')">Disetujui</button>
                                                    </form>
                                                    <form action="{{ route('sempro.updateStatus', $sempro->id) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="Ditolak">
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Apakah Anda yakin ingin menolak seminar proposal ini?')">Ditolak</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="">
                                @php
                                    $sempro = $semproUser->first();
                                    $isEdit = $sempro ? true : false;
                                @endphp

                                <form id="formSempro"
                                    action="{{ $isEdit ? route('sempro.update', $sempro->id) : route('sempro.store') }}"
                                    method="POST" enctype="multipart/form-data">

                                    @csrf
                                    @if ($isEdit)
                                        @method('PUT')
                                    @endif

                                    {{-- No. TA --}}
                                    <div class="mb-3">
                                        <label for="no_ta" class="form-label">No. TA</label>
                                        <input type="text" class="form-control" id="no_ta" name="no_ta"
                                            value="{{ old('no_ta', $sempro->no_ta ?? '') }}"
                                            {{ $isEdit ? 'disabled' : 'required' }}>
                                    </div>

                                    {{-- Pengusul 1 --}}
                                    <div class="mb-3">
                                        <label for="pengusul1" class="form-label">Pengusul 1</label>
                                        <select class="form-select" id="pengusul1" name="pengusul1"
                                            {{ $isEdit ? 'disabled' : 'required' }}>
                                            <option hidden value="">Pilih Pengusul 1</option>
                                            @foreach ($mahasiswas as $mahasiswa)
                                                <option value="{{ $mahasiswa->id }}"
                                                    {{ old('pengusul1', $sempro->pengusul1 ?? '') == $mahasiswa->id ? 'selected' : '' }}>
                                                    {{ $mahasiswa->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Pengusul 2 --}}
                                    <div class="mb-3">
                                        <label for="pengusul2" class="form-label">Pengusul 2</label>
                                        <select class="form-select" id="pengusul2" name="pengusul2"
                                            {{ $isEdit ? 'disabled' : '' }}>
                                            <option hidden value="">Pilih Pengusul 2</option>
                                            @foreach ($mahasiswas as $mahasiswa)
                                                <option value="{{ $mahasiswa->id }}"
                                                    {{ old('pengusul2', $sempro->pengusul2 ?? '') == $mahasiswa->id ? 'selected' : '' }}>
                                                    {{ $mahasiswa->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Dosen Pembimbing --}}
                                    <div class="mb-3">
                                        <label for="dospem_id" class="form-label">Dosen Pembimbing</label>
                                        <select class="form-select" id="dospem_id" name="dospem_id"
                                            {{ $isEdit ? 'disabled' : 'required' }}>
                                            <option hidden value="">Pilih Dosen Pembimbing</option>
                                            @foreach ($dospem as $d)
                                                <option value="{{ $d->id }}"
                                                    {{ old('dospem_id', $sempro->dospem_id ?? '') == $d->id ? 'selected' : '' }}>
                                                    {{ $d->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Judul --}}
                                    <div class="mb-3">
                                        <label for="pengajuan_id" class="form-label">Judul</label>
                                        <select class="form-select" id="pengajuan_id" name="pengajuan_id"
                                            {{ $isEdit ? 'disabled' : 'required' }}>
                                            <option hidden value="">Pilih Judul</option>
                                            @foreach ($pengajuan as $p)
                                                <option value="{{ $p->id }}"
                                                    {{ old('pengajuan_id', $sempro->pengajuan_id ?? $p->id) == $p->id ? 'selected' : '' }}>
                                                    {{ $p->judul }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($isEdit)
                                            <input type="hidden" name="pengajuan_id" value="{{ $sempro->pengajuan_id }}">
                                        @endif
                                    </div>

                                    {{-- Abstrak --}}
                                    <div class="mb-3">
                                        <label for="abstrak" class="form-label">Abstrak/Deskripsi</label>
                                        <textarea class="form-control" id="abstrak" name="abstrak" rows="5" {{ $isEdit ? 'disabled' : 'required' }}>{{ old('abstrak', $sempro->abstrak ?? '') }}</textarea>
                                    </div>

                                    {{-- Laporan --}}
                                    <div class="mb-3">
                                        <label for="laporan" class="form-label">Laporan</label>
                                        <input type="file" class="form-control" id="laporan" name="laporan"
                                            accept=".doc,.docx,.pdf"
                                            {{ $isEdit && $sempro->laporan ? 'disabled' : 'required' }}>

                                        @if ($isEdit && $sempro->laporan)
                                            <div class="mt-2">
                                                <a href="{{ asset('storage/file/laporan/' . $sempro->laporan) }}"
                                                    target="_blank" class="btn btn-link text-decoration-none">Lihat
                                                    File</a>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- PPT --}}
                                    <div class="mb-3">
                                        <label for="ppt" class="form-label">PPT</label>
                                        <input type="file" class="form-control" id="ppt" name="ppt"
                                            accept=".ppt,.pptx" {{ $isEdit && $sempro->ppt ? 'disabled' : 'required' }}>

                                        @if ($isEdit && $sempro->ppt)
                                            <div class="mt-2">
                                                <a href="{{ asset('storage/file/ppt/' . $sempro->ppt) }}" target="_blank"
                                                    class="btn btn-link text-decoration-none">Lihat File</a>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Tombol Aksi --}}
                                    <div class="mb-3">
                                        <button type="submit" id="btnSubmit"
                                            class="btn btn-primary {{ $isEdit ? 'd-none' : '' }}">Simpan</button>
                                        <button type="button" id="btnEdit"
                                            class="btn btn-secondary {{ $isEdit ? '' : 'd-none' }}">Edit</button>
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
        document.addEventListener("DOMContentLoaded", function() {
            const editBtn = document.getElementById("btnEdit");
            const submitBtn = document.getElementById("btnSubmit");
            const form = document.getElementById("formSempro");

            if (editBtn) {
                editBtn.addEventListener("click", function() {
                    // Aktifkan semua input/select/textarea
                    form.querySelectorAll("input, select, textarea").forEach(field => {
                        field.removeAttribute("disabled");
                    });

                    // Tampilkan tombol Submit
                    submitBtn.classList.remove("d-none");

                    // Sembunyikan tombol Edit
                    editBtn.classList.add("d-none");
                });
            }
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
            });

        });
    </script>
@endsection
