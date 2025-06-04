@extends('layouts.main')

@section('styles')
    <style>
        .hover-shadow {
            transition: all 0.3s ease-in-out;
        }

        .hover-shadow:hover {
            box-shadow: 0 0.5rem 1.2rem rgba(0, 0, 0, 0.15);
            transform: translateY(-3px);
        }
    </style>
@endsection


@section('content')
    <div class="container-fluid">
        <h4>Selamat datang, {{ auth()->user()->nama }}</h4>
        @if (auth()->user()->role_id == 1)
            <div class="row g-4">
                <!-- Card Mahasiswa -->
                <div class="col-md-6">
                    <div class="card shadow border-0 rounded-4 bg-light bg-gradient hover-shadow transition">
                        <div class="card-body p-4 d-flex align-items-center">
                            <div class="me-4">
                                <div class="rounded-circle d-flex justify-content-center align-items-center"
                                    style="width: 60px; height: 60px; background: #f8d7da;">
                                    <i class="bi bi-person-fill" style="font-size: 1.8rem; color: #dc3545;"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="card-title fw-semibold text-dark mb-1">Jumlah Mahasiswa Akhir</h5>
                                <p class="card-text fs-5 text-muted mb-0">{{ $jumlahMahasiswa }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Dosen -->
                <div class="col-md-6">
                    <div class="card shadow border-0 rounded-4 bg-light bg-gradient hover-shadow transition">
                        <div class="card-body p-4 d-flex align-items-center">
                            <div class="me-4">
                                <div class="rounded-circle d-flex justify-content-center align-items-center"
                                    style="width: 60px; height: 60px; background: #cfe2ff;">
                                    <i class="bi bi-person-fill" style="font-size: 1.8rem; color: #0d6efd;"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="card-title fw-semibold text-dark mb-1">Jumlah Dosen</h5>
                                <p class="card-text fs-5 text-muted mb-0">{{ $jumlahDosen }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif(auth()->user()->role_id == 2)
            <div class="row  g-4">
                <div class="col-md-6">
                    <div class="card shadow border-0 rounded-4 bg-light bg-gradient hover-shadow transition">
                        <div class="card-body p-4 d-flex align-items-center">
                            <div class="me-4">
                                <div class="rounded-circle d-flex justify-content-center align-items-center"
                                    style="width: 60px; height: 60px; background: #f8d7da;">
                                    <i class="bi bi-person-fill" style="font-size: 1.8rem; color: #dc3545;"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="card-title fw-semibold text-dark mb-1">Jumlah Mahasiswa Yang Belum Seminar</h5>
                                <p class="card-text fs-5 text-muted mb-0">{{ $mhsBelumSeminar }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow border-0 rounded-4 bg-light bg-gradient hover-shadow transition">
                        <div class="card-body p-4 d-flex align-items-center">
                            <div class="me-4">
                                <div class="rounded-circle d-flex justify-content-center align-items-center"
                                    style="width: 60px; height: 60px; background: #cfe2ff;">
                                    <i class="bi bi-person-fill" style="font-size: 1.8rem; color: #0d6efd;"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="card-title fw-semibold text-dark mb-1">Jumlah Mahasiswa Yang Sudah Seminar</h5>
                                <p class="card-text fs-5 text-muted mb-0">{{ $mhsSudahSeminar }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif(auth()->user()->role_id == 3)
            <div class="row g-4">
                <div class="col-12">
                    <div class="card shadow border-0 rounded-4">
                        <div class="card-body p-5">

                            <!-- Section: Download Templates -->
                            <div class="mb-4">
                                <h5 class="fw-semibold text-secondary mb-3">Download Template</h5>
                                <div class="row gy-2">
                                    <div class="col-md-6 d-flex align-items-center">
                                        <div class="me-3 fw-medium" style="width: 200px;">Template Laporan Proposal:</div>
                                        <a href="{{ asset('storage/template/Template_Laporan_Sempro.docx') }}"
                                            class="btn btn-outline-primary btn-sm" target="_blank">
                                            Download
                                        </a>
                                    </div>
                                    <div class="col-md-6 d-flex align-items-center">
                                        <div class="me-3 fw-medium" style="width: 200px;">Berita Acara SEMPRO:</div>
                                        <a href="{{ asset('storage/template/Template_Berita_Acara.docx') }}"
                                            class="btn btn-outline-primary btn-sm" target="_blank">
                                            Download
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- Section: Persyaratan -->
                            <h4 class="text-primary fw-bold mb-4">Persyaratan Tugas Akhir Mahasiswa</h4>
                            <p class="mb-4">Untuk dapat mengikuti dan menyelesaikan Tugas Akhir (TA), mahasiswa wajib
                                memenuhi beberapa ketentuan berikut:</p>
                            <ol class="mb-4 ps-3">
                                <li class="mb-2">Mahasiswa <strong>wajib</strong> mengisi form bimbingan sebagai bagian
                                    dari monitoring progres TA.</li>
                                <li class="mb-2">Dosen pembimbing telah ditentukan oleh program studi D-III TI dan JTI
                                    (JTI Malang).</li>
                                <li class="mb-2">Mahasiswa <strong>wajib</strong> melakukan bimbingan secara aktif dengan
                                    jumlah minimal:
                                    <ul class="mt-2">
                                        <li>Dosen pembimbing 1: Minimal <strong>8x</strong> bimbingan</li>
                                        <li>Dosen pembimbing 2: Minimal <strong>5x</strong> bimbingan</li>
                                    </ul>
                                </li>
                                <li class="mb-2">Mahasiswa <strong>wajib</strong> mengunggah file proposal TA (PDF) sesuai
                                    format yang telah ditentukan.</li>
                                <li class="mb-2">Mahasiswa menyiapkan dokumen Berita Acara SEMPRO TA secara mandiri dan
                                    harus ditandatangani oleh seluruh dosen yang bersangkutan serta diserahkan ke admin
                                    program studi.</li>
                                <li class="mb-2">Mahasiswa <strong>wajib</strong> mengikuti SEMPRO sesuai jadwal yang
                                    telah ditentukan oleh panitia TA.</li>
                                <li class="mb-2">Mahasiswa <strong>tidak dapat</strong> mendaftar sidang Tugas Akhir jika
                                    tidak memenuhi syarat jumlah minimal bimbingan.</li>
                                <li class="mb-3">Untuk menjaga formalitas dan profesionalisme dalam pelaksanaan
                                    Seminar/Sidang Tugas Akhir, mahasiswa <strong>wajib</strong> mengenakan pakaian sesuai
                                    ketentuan dresscode berikut:</li>
                            </ol>

                            <!-- Section: Dresscode -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="bg-light p-3 rounded shadow-sm mb-4">
                                        <h5 class="fw-semibold text-secondary">Laki-laki</h5>
                                        <ul class="mb-0">
                                            <li>Kemeja putih polos berlengan panjang</li>
                                            <li>Celana kain hitam (bukan jeans)</li>
                                            <li>Dasi</li>
                                            <li>Sepatu hitam formal tertutup</li>
                                            <li>Jas almamater</li>
                                            <li>Tatanan rambut rapi</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="bg-light p-3 rounded shadow-sm mb-4">
                                        <h5 class="fw-semibold text-secondary">Perempuan</h5>
                                        <ul class="mb-0">
                                            <li>Kemeja putih polos berlengan panjang</li>
                                            <li>Rok kain hitam (bukan jeans)</li>
                                            <li>Dasi</li>
                                            <li>Jas almamater</li>
                                            <li>Kerudung hitam (bagi yang berhijab)</li>
                                            <li>Sepatu hitam formal tertutup</li>
                                            <li>Tatanan rambut rapi bagi yang tidak berhijab</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
