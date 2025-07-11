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
                                                        {{ $sempro->mahasiswa1Sempro->nama }}
                                                    </div>
                                                    <div class="">
                                                        {{ $sempro->mahasiswa2Sempro->nama }}
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
                                                <td style="text-align: center;">
                                                    @if ($sempro->status == 'Disetujui')
                                                        <span class="badge bg-success">{{ $sempro->status }}</span>
                                                    @elseif ($sempro->status == 'Ditolak')
                                                        <span class="badge bg-danger">{{ $sempro->status }}</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ $sempro->status }}</span>
                                                    @endif
                                                </td>
                                                <td style="text-align: center;">
                                                    @if (
                                                        auth()->user()->id == $sempro->dospem1 ||
                                                        auth()->user()->id == $sempro->dospem2
                                                    )
                                                        <form action="{{ route('sempro.updateStatus', $sempro->id) }}"
                                                            method="POST" enctype="multipart/form-data" class="d-inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="Disetujui">
                                                            <button type="submit" class="btn btn-success btn-sm"
                                                                onclick="return confirm('Apakah Anda yakin ingin menerima seminar proposal ini?')">Disetujui</button>
                                                        </form>
                                                        <form action="{{ route('sempro.updateStatus', $sempro->id) }}"
                                                            method="POST" enctype="multipart/form-data" class="d-inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="Ditolak">
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Apakah Anda yakin ingin menolak seminar proposal ini?')">Ditolak</button>
                                                        </form>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            @if ($statusBimbinganTerakhir == 'Maju Sempro')
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

                                        {{-- mahasiswa 1 --}}
                                        <div class="mb-3">
                                            <label for="mahasiswa1" class="form-label">Mahasiswa 1</label>
                                            <select class="form-select" id="mahasiswa1" name="mahasiswa1"
                                                {{ $isEdit ? 'disabled' : 'required' }}>
                                                <option hidden value="">Pilih mahasiswa 1</option>
                                                @foreach ($mahasiswas as $mahasiswa)
                                                    <option value="{{ $mahasiswa->id }}"
                                                        {{ old('mahasiswa1', $sempro->mahasiswa1 ?? '') == $mahasiswa->id ? 'selected' : '' }}>
                                                        {{ $mahasiswa->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- mahasiswa 2 --}}
                                        <div class="mb-3">
                                            <label for="mahasiswa2" class="form-label">Mahasiswa 2</label>
                                            <select class="form-select" id="mahasiswa2" name="mahasiswa2"
                                                {{ $isEdit ? 'disabled' : '' }}>
                                                <option hidden value="">Pilih mahasiswa 2</option>
                                                @foreach ($mahasiswas as $mahasiswa)
                                                    <option value="{{ $mahasiswa->id }}"
                                                        {{ old('mahasiswa2', $sempro->mahasiswa2 ?? '') == $mahasiswa->id ? 'selected' : '' }}>
                                                        {{ $mahasiswa->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- Dosen Pembimbing --}}
                                        <div class="mb-3">
                                            <label for="dospem1" class="form-label">Dosen Pembimbing 1</label>
                                            <select class="form-select" id="dospem1" name="dospem1"
                                                {{ $isEdit ? 'disabled' : 'required' }}>
                                                <option hidden value="">Pilih Dosen Pembimbing</option>
                                                @foreach ($dospem as $d)
                                                    <option value="{{ $d->id }}"
                                                        {{ old('dospem1', $sempro->dospem1 ?? '') == $d->id ? 'selected' : '' }}>
                                                        {{ $d->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="dospem2" class="form-label">Dosen Pembimbing 2</label>
                                            <select class="form-select" id="dospem2" name="dospem2"
                                                {{ $isEdit ? 'disabled' : '' }}>
                                                <option hidden value="">Pilih Dosen Pembimbing</option>
                                                @foreach ($dospem as $d)
                                                    <option value="{{ $d->id }}"
                                                        {{ old('dospem2', $sempro->dospem2 ?? '') == $d->id ? 'selected' : '' }}>
                                                        {{ $d->nama }}
                                                    </option>
                                                @endforeach
                                            </select>



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
                                            <small class="form-text text-muted">
                                                Unggah file laporan dalam format .doc, .docx, atau .pdf. Maksimal ukuran file 10 MB.
                                            </small>
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
                                            <small class="form-text text-muted">
                                                Unggah file presentasi dalam format .ppt atau .pptx. Maksimal ukuran file 10 MB.
                                            </small>
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
                            @else
                                <div class="alert alert-warning">
                                    Anda belum dapat mengisi form Seminar Proposal karena status bimbingan terakhir Anda belum <strong>Maju Sempro</strong>.
                                </div>
                            @endif
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
                stripeClasses: ['table-primary', 'table-light'],
            });

        });
    </script>
@endsection
