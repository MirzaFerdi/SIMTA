@extends('layouts.main')

@section('content')
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow border-0 rounded-4">
                    <div class="card-body p-4">
                        <div class="mb-3 row align-items-center">
                            <div class="col-md-6 col-sm-6 text-start">
                                <h4>Bimbingan</h4>
                            </div>
                            @if ($bolehTambah)
                                <div class="col-md-6 col-sm-6 text-end">
                                    <button type="button" class="btn btn-primary mt-md-0" data-bs-toggle="modal"
                                        data-bs-target="#tambahModal">
                                        Tambah
                                    </button>
                                </div>
                            @endif
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" style="width: 100%" id="myTable">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">No</th>
                                        <th style="text-align: center;">Tanggal</th>
                                        <th>Topik Bimbingan</th>
                                        <th>Mahasiswa</th>
                                        <th>Dosen Pembimbing</th>
                                        <th style="text-align: center;">File</th>
                                        <th>Review</th>
                                        <th style="text-align: center;">Status</th>
                                        <th style="text-align: center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @if (auth()->user()->role_id == 3) --}}
                                    @foreach ($bimbinganUser as $bim)
                                        <tr>
                                            <td style="text-align: center;">{{ $loop->iteration }}</td>
                                            <td style="text-align: center;">{{ $bim->tanggal }}</td>
                                            <td>{{ $bim->topik_bimbingan }}</td>
                                            <td>
                                                <ul>
                                                    <li>{{ $bim->pengusul1Bimbingan->nama }}</li>
                                                    <li>{{ $bim->pengusul2Bimbingan->nama }}</li>
                                                </ul>
                                            <td>{{ $bim->dospemBimbingan->nama }}</td>
                                            <td>
                                                @if ($bim->file)
                                                    <a href="{{ asset('storage/file/bimbingan/' . $bim->file) }}"
                                                        target="_blank" class="btn btn-sm">Lihat File</a>
                                                @else
                                                    Tidak ada file
                                                @endif
                                            </td>
                                            <td>
                                                @if ($bim->review)
                                                    {{ $bim->review }}
                                                @else
                                                    Tidak ada review
                                                @endif
                                            </td>
                                            <td style="text-align: center;">{{ $bim->status }}</td>
                                            <td style="text-align: center;">
                                                @if (auth()->user()->role_id == 3 &&
                                                        (($bimbinganUser->count() > 0 && $bimbinganUser->last()->status == 'Bimbingan Ulang') ||
                                                            $bimbinganUser->last()->status == 'Menunggu' ||
                                                            $bimbinganUser->isEmpty()))
                                                    <button type="button" class="btn btn-warning btn-sm"
                                                        data-bs-toggle="modal"
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
                                                @elseif(auth()->user()->role_id == 2)
                                                    <button type="button" class="btn btn-success btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editModal{{ $bim->id }}">
                                                        Detail
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                        {{-- Modal Edit --}}
                                        @if (auth()->user()->role_id == 3)
                                            <div class="modal fade" id="editModal{{ $bim->id }}" tabindex="-1"
                                                aria-labelledby="editModalLabel{{ $bim->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editModalLabel{{ $bim->id }}">
                                                                Edit
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
                                                                    <input type="date" class="form-control"
                                                                        id="tanggal" name="tanggal"
                                                                        value="{{ $bim->tanggal }}" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="topik_bimbingan" class="form-label">Topik
                                                                        Bimbingan</label>
                                                                    <textarea class="form-control" id="topik_bimbingan" name="topik_bimbingan" rows="5" required>{{ $bim->topik_bimbingan }}</textarea>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="dospem_id" class="form-label">Dosen
                                                                        Pembimbing</label>
                                                                    <select class="form-select" id="dospem_id"
                                                                        name="dospem_id" required>
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
                                                                <div class="mb-3">
                                                                    <label for="file" class="form-label">File</label>
                                                                    <input type="file" class="form-control"
                                                                        id="file" name="file">
                                                                    <small class="text-muted">Biarkan kosong jika tidak
                                                                        ingin
                                                                        mengubah file.</small>
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
                                        @else
                                            {{-- Modal Edit untuk Dosen Pembimbing --}}
                                            <div class="modal fade" id="editModal{{ $bim->id }}" tabindex="-1"
                                                aria-labelledby="editModalLabel{{ $bim->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="editModalLabel{{ $bim->id }}">
                                                                Edit
                                                                Bimbingan</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('bimbingan.updateStatus', $bim->id) }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="status"
                                                                        class="form-label">Status</label>
                                                                    <select class="form-select" id="status"
                                                                        name="status" required>
                                                                        <option value="Maju Sempro"
                                                                            {{ $bim->status == 'Maju Sempro' ? 'selected' : '' }}>
                                                                            Maju Sempro</option>
                                                                        <option value="Bimbingan Ulang"
                                                                            {{ $bim->status == 'Bimbingan Ulang' ? 'selected' : '' }}>
                                                                            Bimbingan Ulang</option>
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="review"
                                                                        class="form-label">Review</label>
                                                                    <textarea class="form-control" id="review" name="review" rows="5">{{ $bim->review }}</textarea>
                                                                    <small class="text-muted">Isi review jika ada.</small>
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
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                            @if (auth()->user()->role_id == 3)
                                <div class="d-flex justify-content-end">
                                    <a href="#" class="btn btn-secondary mt-3" target="_blank">Cetak Form
                                        Bimbingan</a>
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
                                    <form action="{{ route('bimbingan.store') }}" method="POST"
                                        enctype="multipart/form-data">
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
                                                <label for="file" class="form-label">File</label>
                                                <input type="file" class="form-control" id="file"
                                                    name="file">
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
