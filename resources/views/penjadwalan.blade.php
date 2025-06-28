@extends('layouts.main')

@section('content')
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
                                        <h5>{{ $jadwalUser->first()->tahun_akademik ?? '-' }}</h5>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" style="width: 100%;" id="myTable">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">No</th>
                                        <th style="text-align: center;">Tanggal</th>
                                        <th style="text-align: center;">Jam</th>
                                        <th style="text-align: center;">Tempat</th>
                                        <th>Judul</th>
                                        <th>Mahasiswa</th>
                                        <th>Dosen Pembimbing</th>
                                        <th>Dosen Penguji</th>
                                        <th style="text-align: center;">Status</th>
                                        @if (auth()->user()->role_id == 1)
                                            <th style="text-align: center;">Aksi</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (auth()->user()->role_id == 1)
                                        @foreach ($jadwals as $jadwal)
                                            <tr>
                                                <td style="text-align: center;">{{ $loop->iteration }}</td>
                                                <td style="text-align: center;">{{ $jadwal->tanggal }}</td>
                                                <td style="text-align: center;">{{ $jadwal->jam }}</td>
                                                <td style="text-align: center;">{{ $jadwal->tempat }}</td>
                                                <td>{{ $jadwal->pengajuan->judul }}</td>
                                                <td>
                                                    <ul>
                                                        <li>
                                                            {{ $jadwal->pengusul1Jadwal->nama }}
                                                        </li>
                                                        <li>
                                                            {{ $jadwal->pengusul2Jadwal->nama }}
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td>
                                                    <ul>
                                                        <li>
                                                            {{ $jadwal->dospem1Jadwal->nama }}
                                                        </li>
                                                        <li>
                                                            {{ $jadwal->dospem2Jadwal->nama }}
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td>
                                                    <ul>
                                                        <li>
                                                            {{ $jadwal->dosenPenguji1Jadwal->nama }}
                                                        </li>
                                                        <li>
                                                            {{ $jadwal->dosenPenguji2Jadwal->nama }}
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td style="text-align: center;">
                                                    @if ($jadwal->status == 'Belum Diseminarkan')
                                                        <span class="badge bg-secondary">{{ $jadwal->status }}</span>
                                                    @elseif ($jadwal->status == 'Telah Diseminarkan')
                                                        <span class="badge bg-success">{{ $jadwal->status }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-warning btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editModal{{ $jadwal->id }}">
                                                        Edit
                                                    </button>
                                                    <form action="{{ route('penjadwalan.destroy', $jadwal->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Yakin ingin menghapus?')">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            {{-- Edit Modal --}}
                                            <div class="modal fade" id="editModal{{ $jadwal->id }}" tabindex="-1"
                                                aria-labelledby="editModalLabel{{ $jadwal->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editModalLabel{{ $jadwal->id }}">
                                                                Edit
                                                                Jadwal</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('penjadwalan.update', $jadwal->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="tahun_akademik" class="form-label">Tahun
                                                                        Akademik</label>
                                                                    <input type="text" class="form-control"
                                                                        id="tahun_akademik" name="tahun_akademik"
                                                                        value="{{ $jadwal->tahun_akademik }}" required>
                                                                    <div class="mb-3">
                                                                        <label for="tanggal"
                                                                            class="form-label">Tanggal</label>
                                                                        <input type="date" class="form-control"
                                                                            id="tanggal" name="tanggal"
                                                                            value="{{ $jadwal->tanggal }}" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="jam" class="form-label">Jam</label>
                                                                        <input type="time" class="form-control"
                                                                            id="jam" name="jam"
                                                                            value="{{ $jadwal->jam }}" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="tempat"
                                                                            class="form-label">Tempat</label>
                                                                        <input type="text" class="form-control"
                                                                            id="tempat" name="tempat"
                                                                            value="{{ $jadwal->tempat }}" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="pengajuan_id" class="form-label">Pengajuan</label>
                                                                        <select class="form-select" id="pengajuan_id_edit_{{ $jadwal->id }}" name="pengajuan_id" required>
                                                                            <option hidden value="">Pilih Pengajuan</option>
                                                                            @foreach ($pengajuans as $pengajuan)
                                                                                <option
                                                                                    value="{{ $pengajuan->id }}"
                                                                                    data-pengusul1="{{ $pengajuan->pengusul1Pengajuan->id ?? '' }}"
                                                                                    data-pengusul2="{{ $pengajuan->pengusul2Pengajuan->id ?? '' }}"
                                                                                    data-dospem1="{{ $pengajuan->dospem1Pengajuan->id ?? '' }}"
                                                                                    data-dospem2="{{ $pengajuan->dospem2Pengajuan->id ?? '' }}"
                                                                                    {{ $jadwal->pengajuan_id == $pengajuan->id ? 'selected' : '' }}
                                                                                >
                                                                                    {{ $pengajuan->judul }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="pengusul1" class="form-label">Pengusul
                                                                            1</label>
                                                                        <select class="form-select" id="pengusul1"
                                                                            name="pengusul1" required>
                                                                            <option hidden value="">Pilih Pengusul 1
                                                                            </option>
                                                                            @foreach ($mahasiswas as $mahasiswa)
                                                                                <option value="{{ $mahasiswa->id }}"
                                                                                    {{ $jadwal->pengusul1 == $mahasiswa->id ? 'selected' : '' }}>
                                                                                    {{ $mahasiswa->nama }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="pengusul2" class="form-label">Pengusul
                                                                            2</label>
                                                                        <select class="form-select" id="pengusul2"
                                                                            name="pengusul2">
                                                                            <option hidden value="">Pilih Pengusul 2
                                                                                (Opsional)
                                                                            </option>
                                                                            @foreach ($mahasiswas as $mahasiswa)
                                                                                <option value="{{ $mahasiswa->id }}"
                                                                                    {{ $jadwal->pengusul2 == $mahasiswa->id ? 'selected' : '' }}>
                                                                                    {{ $mahasiswa->nama }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="dospem1" class="form-label">Dosen
                                                                            Pembimbing 1</label>
                                                                        <select class="form-select" id="dospem1"
                                                                            name="dospem1" required>
                                                                            <option hidden value="">Pilih Dosen
                                                                                Pembimbing</option>
                                                                            @foreach ($dosens as $dosen)
                                                                                <option value="{{ $dosen->id }}"
                                                                                    {{ $jadwal->dospem1 == $dosen->id ? 'selected' : '' }}>
                                                                                    {{ $dosen->nama }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="dospem2" class="form-label">Dosen
                                                                            Pembimbing 2</label>
                                                                        <select class="form-select" id="dospem2"
                                                                            name="dospem2">
                                                                            <option hidden value="">Pilih Dosen
                                                                                Pembimbing 2 (Opsional)</option>
                                                                            @foreach ($dosens as $dosen)
                                                                                <option value="{{ $dosen->id }}"
                                                                                    {{ $jadwal->dospem2 == $dosen->id ? 'selected' : '' }}>
                                                                                    {{ $dosen->nama }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="dosen_penguji1"
                                                                            class="form-label">Dosen Penguji 1</label>
                                                                        <select class="form-select" id="dosen_penguji1"
                                                                            name="dosen_penguji1" required>
                                                                            <option hidden value="">Pilih Dosen
                                                                                Penguji</option>
                                                                            @foreach ($dosens as $dosen)
                                                                                <option value="{{ $dosen->id }}"
                                                                                    {{ $jadwal->dosen_penguji1 == $dosen->id ? 'selected' : '' }}>
                                                                                    {{ $dosen->nama }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="dosen_penguji2"
                                                                            class="form-label">Dosen Penguji 2</label>
                                                                        <select class="form-select" id="dosen_penguji2"
                                                                            name="dosen_penguji2">
                                                                            <option hidden value="">Pilih Dosen
                                                                                Penguji 2 (Opsional)</option>
                                                                            @foreach ($dosens as $dosen)
                                                                                <option value="{{ $dosen->id }}"
                                                                                    {{ $jadwal->dosen_penguji2 == $dosen->id ? 'selected' : '' }}>
                                                                                    {{ $dosen->nama }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="status" class="form-label">Status</label>
                                                                    <select class="form-select" id="status"
                                                                        name="status" required>
                                                                        <option value="Belum Diseminarkan"
                                                                            {{ $jadwal->status == 'Belum Diseminarkan' ? 'selected' : '' }}>
                                                                            Belum Diseminarkan</option>
                                                                        <option value="Telah Diseminarkan"
                                                                            {{ $jadwal->status == 'Telah Diseminarkan' ? 'selected' : '' }}>
                                                                            Telah Diseminarkan</option>
                                                                    </select>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Tutup</button>
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Simpan</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        @foreach ($jadwalUser as $jadwal)
                                            <tr>
                                                <td style="text-align: center;">{{ $loop->iteration }}</td>
                                                <td style="text-align: center;">{{ $jadwal->tanggal }}</td>
                                                <td style="text-align: center;">{{ $jadwal->jam }}</td>
                                                <td style="text-align: center;">{{ $jadwal->tempat }}</td>
                                                <td>{{ $jadwal->pengajuan->judul }}</td>
                                                <td>
                                                    <ul>
                                                        <li>
                                                            {{ $jadwal->pengusul1Jadwal->nama }}
                                                        </li>
                                                        <li>
                                                            {{ $jadwal->pengusul2Jadwal->nama }}
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td>
                                                    <ul>
                                                        <li>
                                                            {{ $jadwal->dospem1Jadwal->nama }}
                                                        </li>
                                                        <li>
                                                            {{ $jadwal->dospem2Jadwal->nama }}
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td>
                                                    <ul>
                                                        <li>
                                                            {{ $jadwal->dosenPenguji1Jadwal->nama }}
                                                        </li>
                                                        <li>
                                                            {{ $jadwal->dosenPenguji2Jadwal->nama }}
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td style="text-align: center;">
                                                    @if ($jadwal->status == 'Belum Diseminarkan')
                                                        <span class="badge bg-secondary">{{ $jadwal->status }}</span>
                                                    @elseif ($jadwal->status == 'Telah Diseminarkan')
                                                        <span class="badge bg-success">{{ $jadwal->status }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tambah Modal --}}
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalLabel">Tambah Jadwal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('penjadwalan.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tahun_akademik" class="form-label">Tahun Akademik</label>
                            <input type="text" class="form-control" id="tahun_akademik" name="tahun_akademik"
                                value="{{ date('Y') }}/{{ date('Y') + 1 }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                        </div>
                        <div class="mb-3">
                            <label for="jam" class="form-label">Jam</label>
                            <input type="time" class="form-control" id="jam" name="jam" required>
                        </div>
                        <div class="mb-3">
                            <label for="tempat" class="form-label">Tempat</label>
                            <input type="text" class="form-control" id="tempat" name="tempat" required>
                        </div>
                        <div class="mb-3">
                            <label for="pengajuan_id" class="form-label">Pengajuan</label>
                            <select class="form-select" id="pengajuan_id_tambah" name="pengajuan_id" required>
                                <option hidden value="">Pilih Pengajuan</option>
                                @foreach ($pengajuans as $pengajuan)
                                    <option
                                        value="{{ $pengajuan->id }}"
                                        data-pengusul1="{{ $pengajuan->pengusul1Pengajuan->id ?? '' }}"
                                        data-pengusul2="{{ $pengajuan->pengusul2Pengajuan->id ?? '' }}"
                                        data-dospem1="{{ $pengajuan->dospem1Pengajuan->id ?? '' }}"
                                        data-dospem2="{{ $pengajuan->dospem2Pengajuan->id ?? '' }}"
                                    >
                                        {{ $pengajuan->judul }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="pengusul1" class="form-label">Pengusul 1</label>
                            <select class="form-select" id="pengusul1" name="pengusul1" required>
                                <option hidden value="">Pilih Pengusul 1</option>
                                @foreach ($mahasiswas as $mahasiswa)
                                    <option value="{{ $mahasiswa->id }}">{{ $mahasiswa->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="pengusul2" class="form-label">Pengusul 2</label>
                            <select class="form-select" id="pengusul2" name="pengusul2">
                                <option hidden value="">Pilih Pengusul 2</option>
                                @foreach ($mahasiswas as $mahasiswa)
                                    <option value="{{ $mahasiswa->id }}">{{ $mahasiswa->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="dospem1" class="form-label">Dosen Pembimbing 1</label>
                            <select class="form-select" id="dospem1" name="dospem1" required>
                                <option hidden value="">Pilih Dosen Pembimbing</option>
                                @foreach ($dosens as $dosen)
                                    <option value="{{ $dosen->id }}">{{ $dosen->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="dospem2" class="form-label">Dosen Pembimbing 2</label>
                            <select class="form-select" id="dospem2" name="dospem2">
                                <option hidden value="">Pilih Dosen Pembimbing 2</option>
                                @foreach ($dosens as $dosen)
                                    <option value="{{ $dosen->id }}">{{ $dosen->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="dosen_penguji1" class="form-label">Dosen Penguji 1</label>
                            <select class="form-select" id="dosen_penguji1" name="dosen_penguji1" required>
                                <option hidden value="">Pilih Dosen Penguji</option>
                                @foreach ($dosens as $dosen)
                                    <option value="{{ $dosen->id }}">{{ $dosen->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="dosen_penguji2" class="form-label">Dosen Penguji 2</label>
                            <select class="form-select" id="dosen_penguji2" name="dosen_penguji2">
                                <option hidden value="">Pilih Dosen Penguji 2</option>
                                @foreach ($dosens as $dosen)
                                    <option value="{{ $dosen->id }}">{{ $dosen->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="Belum Diseminarkan">Belum Diseminarkan</option>
                                <option value="Telah Diseminarkan">Telah Diseminarkan</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('tahun_akademik').addEventListener('change', function() {
            const selectedYear = this.value;
            window.location.href = `/penjadwalan?tahun_akademik=${selectedYear}`;
        });
    </script>
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

            // Fungsi untuk mengisi form pengusul dan dospem
            function fillPengusulDospem(pengajuanSelectElement) {
                var selectedOption = $(pengajuanSelectElement).find('option:selected');
                var modalContainer = $(pengajuanSelectElement).closest('.modal-body');

                var pengusul1Id = selectedOption.data('pengusul1');
                var pengusul2Id = selectedOption.data('pengusul2');
                var dospem1Id = selectedOption.data('dospem1');
                var dospem2Id = selectedOption.data('dospem2');

                modalContainer.find('select[name="pengusul1"]').val(pengusul1Id).trigger('change');
                modalContainer.find('select[name="pengusul2"]').val(pengusul2Id).trigger('change');
                modalContainer.find('select[name="dospem1"]').val(dospem1Id).trigger('change');
                modalContainer.find('select[name="dospem2"]').val(dospem2Id).trigger('change');
            }

            // Event listener untuk Modal Tambah Jadwal
            $('#pengajuan_id_tambah').on('change', function() {
                fillPengusulDospem(this);
            });

            // Event listener untuk Modal Edit Jadwal (menggunakan event delegation)
            $(document).on('change', 'select[id^="pengajuan_id_edit_"]', function() {
                fillPengusulDospem(this);
            });

            // PENTING: Panggil fungsi ini saat modal dibuka agar data terisi awal
            $('#tambahModal').on('shown.bs.modal', function () {
                // Panggil hanya jika ada pengajuan_id yang sudah terpilih secara default
                if ($(this).find('#pengajuan_id_tambah').val()) {
                    fillPengusulDospem($(this).find('#pengajuan_id_tambah'));
                }
            });

            $('[id^="editModal"]').on('shown.bs.modal', function () {
                var modalId = $(this).attr('id');
                var pengajuanSelect = $('#' + modalId).find('select[name="pengajuan_id"]');
                fillPengusulDospem(pengajuanSelect);
            });
        });
    </script>
@endsection

