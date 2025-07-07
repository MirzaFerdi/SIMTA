<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengajuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pengajuan_juduls')->insert([
            'mahasiswa1' => 6,
            'mahasiswa2' => 7,
            'dospem1' => 2,
            'dospem2' => 3,
            'tahun' => 2025,
            'judul' => 'Judul Pengajuan 1',
            'status' => 'Disetujui',
        ]);
    }
}
