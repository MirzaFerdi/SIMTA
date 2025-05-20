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
            'pengusul1' => 3,
            'pengusul2' => 4,
            'tahun' => 2025,
            'judul' => 'Judul Pengajuan 1',
            'status' => 'pending'
        ]);
    }
}
