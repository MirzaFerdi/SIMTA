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
                'nama' => 'Dion Cahya',
                'username' => '1131740001',
                'password' => bcrypt('admin'),
                'encrypted_password' => Crypt::encryptString('admin'),
                'email' => 'admin@mail.com',
                'foto' => 'admin.jpg',
                'prodi' => 'Teknik Informatika',
            ],
            [
                'role_id' => 2,
                'nama' => 'Alvionitha',
                'username' => '1231740001',
                'password' => bcrypt('dosen'),
                'encrypted_password' => Crypt::encryptString('dosen'),
                'email' => 'dosen@mail.com',
                'foto' => 'dosen.jpg',
                'prodi' => 'Teknik Informatika',
            ],
            [
                'role_id' => 2,
                'nama' => 'Eko Prabowo',
                'username' => '1231740002',
                'password' => bcrypt('dosen2'),
                'encrypted_password' => Crypt::encryptString('dosen2'),
                'email' => 'dosen2@mail.com',
                'foto' => 'dosen2.jpg',
                'prodi' => 'Teknik Informatika',
            ],
            [
                'role_id' => 2,
                'nama' => 'Siti Aminah',
                'username' => '1231740003',
                'password' => bcrypt('dosen3'),
                'encrypted_password' => Crypt::encryptString('dosen3'),
                'email' => 'siti@mail.com',
                'foto' => 'dosen3.jpg',
                'prodi' => 'Teknik Informatika',
            ],
            [
                'role_id' => 2,
                'nama' => 'Rudi Hartono',
                'username' => '1231740004',
                'password' => bcrypt('dosen4'),
                'encrypted_password' => Crypt::encryptString('dosen4'),
                'email' => 'rudi@mail.com',
                'foto' => 'dosen4.jpg',
                'prodi' => 'Teknik Informatika',
            ],
            [
                'role_id' => 3,
                'nama' => 'Abdul Rahman',
                'username' => '2131740011',
                'password' => bcrypt('mahasiswa'),
                'encrypted_password' => Crypt::encryptString('mahasiswa'),
                'email' => 'mahasiswa1@mail.com',
                'foto' => 'mahasiswa1.jpg',
                'prodi' => 'Teknik Informatika',
            ],
            [
                'role_id' => 3,
                'nama' => 'Budi Santoso',
                'username' => '2131740012',
                'password' => bcrypt('mahasiswa'),
                'encrypted_password' => Crypt::encryptString('mahasiswa'),
                'email' => 'mahasiswa2@mail.com',
                'foto' => 'mahasiswa2.jpg',
                'prodi' => 'Teknik Informatika',
            ],
            [
                'role_id' => 3,
                'nama' => 'Citra Ayu',
                'username' => '2131740013',
                'password' => bcrypt('mahasiswa'),
                'encrypted_password' => Crypt::encryptString('mahasiswa'),
                'email' => 'mahasiswa3@mail.com',
                'foto' => 'mahasiswa3.jpg',
                'prodi' => 'Teknik Informatika',
            ],
            [
                'role_id' => 3,
                'nama' => 'Dewi Lestari',
                'username' => '2131740014',
                'password' => bcrypt('mahasiswa'),
                'encrypted_password' => Crypt::encryptString('mahasiswa'),
                'email' => 'mahasiswa4@mail.com',
                'foto' => 'mahasiswa4.jpg',
                'prodi' => 'Teknik Informatika',
            ],
        ]);
    }
}
