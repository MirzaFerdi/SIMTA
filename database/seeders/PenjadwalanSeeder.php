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
                'pengusul1' => 6,
                'pengusul2' => 7,
                'pengajuan_id' => 1,
                'dospem1' => 2,
                'dospem2' => 3,
                'dosen_penguji1' => 4,
                'dosen_penguji2' => 5,
                'tanggal' => '2023-10-01',
                'tahun_akademik' => '2023/2024',
                'jam' => '09:00:00',
                'tempat' => 'Ruang A',
                'status' => 'Belum Diseminarkan',
            ],

        ]);
    }
}
