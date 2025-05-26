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
            'pengusul1' => 3,
            'pengusul2' => 4,
            'dospem_id' => 2,
            'tanggal' => now(),
            'topik_bimbingan' => 'Topik Bimbingan 1',
            'status' => 'Diproses'
        ]);
    }
}
