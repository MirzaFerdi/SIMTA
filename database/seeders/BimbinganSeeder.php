<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BimbinganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bimbingans')->insert([
            'pengusul1' => 6,
            'pengusul2' => 7,
            'dospem_id' => 2,
            'tanggal' => now(),
            'topik_bimbingan' => 'Topik Bimbingan 1',
            'file' => 'bimbingan1.pdf',
            'review' => 'Bimbingan pertama telah dilakukan.',
            'status' => 'Menunggu'
        ]);
    }
}
