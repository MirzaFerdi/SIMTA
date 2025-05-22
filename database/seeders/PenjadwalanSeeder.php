<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjadwalanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jadwals')->insert([
            [
                'pengusul1' => 3,
                'pengusul2' => 4,
                'pengajuan_id' => 1,
                'dospem_id' => 2,
                'tanggal' => '2023-10-01',
                'tahun_akademik' => '2023/2024',
                'jam' => '09:00:00',
                'tempat' => 'Ruang A',
                'jenis_ujian' => 'Skripsi'
            ],

        ]);
    }
}
