@extends('layouts.main')

@section('content')
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow border-0 rounded-4">
                    <div class="card-body p-4">
                        <h4 class="mb-3">Rekap Hasil Seminar</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered nowrap" style="width: 100%;" id="myTable">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">No</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>Nama Dosen</th>
                                        <th>Judul TA</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rekapSeminar as $rekap)
                                        <tr>
                                            <td style="text-align: center;">{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="">
                                                    {{ $rekap->pengusul1BeritaAcara->nama }}
                                                </div>
                                                <div class="">
                                                    {{ $rekap->pengusul2BeritaAcara->nama }}
                                                </div>
                                            </td>
                                            <td>{{ $rekap->dosenBeritaAcara->nama }}</td>
                                            <td>{{ $rekap->pengajuanBeritaAcara->judul }}</td>
                                            <td>
                                                {{ $rekap->status }}
                                            </td>
                                        </tr>
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
                responsive: true,
                autoWidth: false,
            });

        });
    </script>
@endsection
