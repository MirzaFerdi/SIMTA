<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BeritaAcaraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('berita_acaras')->insert([
            'pengusul1' => 6,
            'pengusul2' => 7,
            'dosen' => 2,
            'pengajuan_id' => 1,
            'berita_acara' => 'BeritaAcara_1.pdf',
            'status' => 'Telah Diseminarkan'
        ]);
    }
}
