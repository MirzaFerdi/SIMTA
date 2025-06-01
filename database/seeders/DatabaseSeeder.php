<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            PengajuanSeeder::class,
            BimbinganSeeder::class,
            PenjadwalanSeeder::class,
            TugasAkhirSeeder::class,
            SemproSeeder::class,
            // BeritaAcaraSeeder::class,
            // Add other seeders here if needed
        ]);
    }
}
