<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TugasAkhirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tugas_akhirs')->insert([
            [
                'pengusul1' => 3,
                'pengusul2' => 4,
                'dospem_id' => 2,
                'pengajuan_id' => 1,
                'no_ta' => 'AB2024',
                'abstrak' => 'Skripsi ini membahas tentang pengembangan aplikasi berbasis web untuk manajemen data mahasiswa.',
                'laporan' => 'laporan.pdf',
                'ppt' => 'presentasi.pptx',
                'berita_acara' => 'berita_acara.pdf',
                'bimbingan' => 'bimbingan.pdf',
                'status' => 'Diproses',

            ],
        ]);
    }
}
