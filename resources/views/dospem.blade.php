@extends('layouts.main')

@section('content')
<div class="container mt-3">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-4">
                    <h4 class="mb-3">
                        Dosen Pembimbing
                    </h4>
                    <div class="table-responsive">
                        <table class="table table-bordered " style="width: 100%" id="myTable">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">No</th>
                                    <th>Mahasiswa</th>
                                    <th>Judul</th>
                                    <th>Dosen Pembimbing 1</th>
                                    <th>Dosen Pembimbing 2</th>
                                    <th style="text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dospems as $dospem)
                                <tr>
                                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="">
                                            <ul>
                                                <li>{{ $dospem->mahasiswa1Pengajuan->nama }}</li>
                                                <li>{{ $dospem->mahasiswa2Pengajuan->nama }}</li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td>{{ $dospem->judul }}</td>
                                    <td>{{ $dospem->dospem1Pengajuan->nama }}</td>
                                    <td>{{ $dospem->dospem2Pengajuan ? $dospem->dospem2Pengajuan->nama : '-' }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-warning" id="editDospemBtn"
                                            data-id="{{ $dospem->id }}" data-bs-toggle="modal"
                                            data-bs-target="#editDospemModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal Edit -->
                                <div class="modal fade" id="editDospemModal" tabindex="-1"
                                    aria-labelledby="editDospemModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editDospemModalLabel">Edit Dosen Pembimbing</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="editDospemForm" method="POST"
                                                    action="{{ route('dospem.update', $dospem->id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label for="judul" class="form-label">Judul</label>
                                                        <input type="text" class="form-control" id="judul" name="judul"
                                                            value="{{ $dospem->judul }}" disabled>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="dospem1" class="form-label">Dosen Pembimbing 1</label>
                                                        <select class="form-select" id="dospem1" name="dospem1"
                                                            required>
                                                            @foreach ($dosen as $dos)
                                                            <option value="{{ $dos->id }}"
                                                                {{ $dos->id == $dospem->dospem1 ? 'selected' : '' }}>
                                                                {{ $dos->nama }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="dospem2" class="form-label">Dosen Pembimbing 2</label>
                                                        <select class="form-select" id="dospem2" name="dospem2">
                                                            <option hidden value="">Tidak Ada</option>
                                                            @foreach ($dosen as $dos)
                                                            <option value="{{ $dos->id }}"
                                                                {{ $dos->id == $dospem->dospem2 ? 'selected' : '' }}>
                                                                {{ $dos->nama }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-primary">Simpan
                                                            Perubahan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
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
