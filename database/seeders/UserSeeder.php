<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
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
                'username' => '1131740001',
                'password' => bcrypt('admin'),
                'encrypted_password' => Crypt::encryptString('admin'),
                'email' => 'admin@mail.com',
                'foto' => 'admin.jpg',
                'prodi' => 'Teknik Informatika',
            ],
            [
                'role_id' => 2,
                'nama' => 'Dosen',
                'username' => '1231740001',
                'password' => bcrypt('dosen'),
                'encrypted_password' => Crypt::encryptString('dosen'),
                'email' => 'dosen@mail.com',
                'foto' => 'dosen.jpg',
                'prodi' => 'Teknik Informatika',
            ],
            [
                'role_id' => 3,
                'nama' => 'Mahasiswa',
                'username' => '2131740011',
                'password' => bcrypt('mahasiswa'),
                'encrypted_password' => Crypt::encryptString('mahasiswa'),
                'email' => 'mahasiswa1@mail.com',
                'foto' => 'mahasiswa1.jpg',
                'prodi' => 'Teknik Informatika',
            ],
            [
                'role_id' => 3,
                'nama' => 'Mahasiswa 2',
                'username' => '2131740012',
                'password' => bcrypt('mahasiswa'),
                'encrypted_password' => Crypt::encryptString('mahasiswa'),
                'email' => 'mahasiswa2@mail.com',
                'foto' => 'mahasiswa2.jpg',
                'prodi' => 'Teknik Informatika',
            ],
        ]);
    }
}
