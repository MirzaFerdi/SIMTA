@extends('layouts.main')

@section('content')
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <!-- Tab Navigation -->
                <ul class="nav nav-tabs" id="bimbinganTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="dospem1-tab" data-bs-toggle="tab" data-bs-target="#dospem1"
                            type="button" role="tab" aria-controls="dospem1" aria-selected="true">
                            Bimbingan Pembimbing 1
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="dospem2-tab" data-bs-toggle="tab" data-bs-target="#dospem2"
                            type="button" role="tab" aria-controls="dospem2" aria-selected="false">
                            Bimbingan Pembimbing 2
                        </button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content" id="bimbinganTabsContent">
                    <!-- Tab Pembimbing 1 -->
                    <div class="tab-pane fade show active" id="dospem1" role="tabpanel" aria-labelledby="dospem1-tab">
                        <div class="card shadow border-0 rounded-4 rounded-top-0">
                            <div class="card-body p-4">
                                <div class="mb-3 row align-items-center">
                                    <div class="col-md-6 col-sm-6 text-start">
                                        <h4>Bimbingan Pembimbing 1</h4>
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
                                    <table class="table table-bordered" style="width: 100%" id="dospem1Table">
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
                                            @foreach ($bimbinganDospem1 as $bim)
                                                <tr>
                                                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                                                    <td style="text-align: center;">{{ $bim->tanggal }}</td>
                                                    <td>{{ $bim->topik_bimbingan }}</td>
                                                    <td>
                                                        <ul>
                                                            <li>{{ $bim->pengusul1Bimbingan->nama }}</li>
                                                            <li>{{ $bim->pengusul2Bimbingan->nama }}</li>
                                                        </ul>
                                                    </td>
                                                    <td>{{ $bim->dospem1Bimbingan->nama ?? '' }}</td>
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
                                                    <td style="text-align: center;">
                                                        @if ($bim->status == 'Bimbingan Ulang')
                                                            <span
                                                                class="badge bg-warning text-dark">{{ $bim->status }}</span>
                                                        @elseif ($bim->status == 'Maju Sempro')
                                                            <span class="badge bg-success">{{ $bim->status }}</span>
                                                        @else
                                                            <span class="badge bg-secondary">{{ $bim->status }}</span>
                                                        @endif
                                                    </td>
                                                    <td style="text-align: center;">
                                                        @if (auth()->user()->role_id == 3 &&
                                                                (($bimbinganDospem1->count() > 0 && $bimbinganDospem1->last()->status == 'Bimbingan Ulang') ||
                                                                    $bimbinganDospem1->last()->status == 'Menunggu' ||
                                                                    $bimbinganDospem1->isEmpty()))
                                                            <button type="button" class="btn btn-warning btn-sm"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editModal{{ $bim->id }}">
                                                                Edit
                                                            </button>
                                                            <form action="{{ route('bimbingan.delete', $bim->id) }}"
                                                                method="POST" class="d-inline">
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
                                                @include('bimbingan.modal-edit', ['bim' => $bim])
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
                            </div>
                        </div>
                    </div>

                    <!-- Tab Pembimbing 2 -->
                    <div class="tab-pane fade" id="dospem2" role="tabpanel" aria-labelledby="dospem2-tab">
                        <div class="card shadow border-0 rounded-4 rounded-top-0">
                            <div class="card-body p-4">
                                <div class="mb-3 row align-items-center">
                                    <div class="col-md-6 col-sm-6 text-start">
                                        <h4>Bimbingan Pembimbing 2</h4>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered" style="width: 100%" id="dospem2Table">
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
                                            @foreach ($bimbinganDospem2 as $bim)
                                                <tr>
                                                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                                                    <td style="text-align: center;">{{ $bim->tanggal }}</td>
                                                    <td>{{ $bim->topik_bimbingan }}</td>
                                                    <td>
                                                        <ul>
                                                            <li>{{ $bim->pengusul1Bimbingan->nama }}</li>
                                                            <li>{{ $bim->pengusul2Bimbingan->nama }}</li>
                                                        </ul>
                                                    </td>
                                                    <td>{{ $bim->dospem2Bimbingan->nama ?? '' }}</td>
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
                                                    <td style="text-align: center;">
                                                        @if ($bim->status == 'Bimbingan Ulang')
                                                            <span
                                                                class="badge bg-warning text-dark">{{ $bim->status }}</span>
                                                        @elseif ($bim->status == 'Maju Sempro')
                                                            <span class="badge bg-success">{{ $bim->status }}</span>
                                                        @else
                                                            <span class="badge bg-secondary">{{ $bim->status }}</span>
                                                        @endif
                                                    </td>
                                                    <td style="text-align: center;">
                                                        @if (auth()->user()->role_id == 3 &&
                                                                (($bimbinganDospem2->count() > 0 && $bimbinganDospem2->last()->status == 'Bimbingan Ulang') ||
                                                                    $bimbinganDospem2->last()->status == 'Menunggu' ||
                                                                    $bimbinganDospem2->isEmpty()))
                                                            <button type="button" class="btn btn-warning btn-sm"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editModal{{ $bim->id }}">
                                                                Edit
                                                            </button>
                                                            <form action="{{ route('bimbingan.delete', $bim->id) }}"
                                                                method="POST" class="d-inline">
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
                                                @include('bimbingan.modal-edit', ['bim' => $bim])
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
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
                            <form action="{{ route('bimbingan.store') }}" method="POST" enctype="multipart/form-data">
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
                                        <input type="file" class="form-control" id="file" name="file"
                                            accept=".pdf,.doc,.docx">
                                        <small class="text-muted">
                                            Unggah file bimbingan (.pdf, .doc, .docx), maksimal 10MB.
                                        </small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="dospem_type" class="form-label">Jenis Pembimbing</label>
                                        <select class="form-select" id="dospem_type" name="dospem_type" required>
                                            <option hidden value="">Pilih Jenis Pembimbing</option>
                                            <option value="dospem1">Pembimbing 1</option>
                                            <option value="dospem2">Pembimbing 2</option>
                                        </select>
                                    </div>

                                    <div class="mb-3" id="dospem1-container">
                                        <label for="dospem1" class="form-label">Dosen Pembimbing 1</label>
                                        <select class="form-select" id="dospem1" name="dospem1">
                                            <option hidden value="">Pilih Dosen Pembimbing 1</option>
                                            @foreach ($dospem as $dos)
                                                <option value="{{ $dos->id }}">{{ $dos->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3 d-none" id="dospem2-container">
                                        <label for="dospem2" class="form-label">Dosen Pembimbing 2</label>
                                        <select class="form-select" id="dospem2" name="dospem2">
                                            <option hidden value="">Pilih Dosen Pembimbing 2</option>
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
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#dospem1Table').DataTable({
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

            $('#dospem2Table').DataTable({
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
                width: "100%"
            });
        });

        document.getElementById('dospem_type').addEventListener('change', function() {
            const type = this.value;
            const dospem1Container = document.getElementById('dospem1-container');
            const dospem2Container = document.getElementById('dospem2-container');

            // Sembunyikan semua container terlebih dahulu
            dospem1Container.classList.add('d-none');
            dospem2Container.classList.add('d-none');

            // Hapus required attribute dari kedua select
            document.getElementById('dospem1').removeAttribute('required');
            document.getElementById('dospem2').removeAttribute('required');

            // Tampilkan container yang sesuai dan set required
            if (type === 'dospem1') {
                dospem1Container.classList.remove('d-none');
                document.getElementById('dospem1').setAttribute('required', 'required');
            } else if (type === 'dospem2') {
                dospem2Container.classList.remove('d-none');
                document.getElementById('dospem2').setAttribute('required', 'required');
            }
        });
    </script>
@endsection
