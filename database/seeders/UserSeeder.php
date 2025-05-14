<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'role_id' => 1,
                'nama' => 'Admin',
                'username' => 'admin',
                'password' => bcrypt('admin'),
                'email' => 'admin@mail.com',
                'foto' => 'admin.jpg',
                'prodi' => 'Teknik Informatika',
            ],
            [
                'role_id' => 2,
                'nama' => 'Dosen',
                'username' => 'dosen',
                'password' => bcrypt('dosen'),
                'email' => 'dosen@mail.com',
                'foto' => 'dosen.jpg',
                'prodi' => 'Teknik Informatika',
            ],
            [
                'role_id' => 3,
                'nama' => 'Mahasiswa',
                'username' => 'mahasiswa',
                'password' => bcrypt('mahasiswa'),
                'email' => 'mahasiswa1@mail.com',
                'foto' => 'mahasiswa1.jpg',
                'prodi' => 'Teknik Informatika',
            ],
            [
                'role_id' => 3,
                'nama' => 'Mahasiswa 2',
                'username' => 'mahasiswa2',
                'password' => bcrypt('mahasiswa2'),
                'email' => 'mahasiswa2@mail.com',
                'foto' => 'mahasiswa2.jpg',
                'prodi' => 'Teknik Informatika',
            ],
        ]);
    }
}
