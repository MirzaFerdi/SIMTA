<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new User([
            'username'  => $row['username'],
            'nama'      => $row['nama'],
            'email'     => $row['email'],
            'password'  => Hash::make($row['password']),
            'encrypted_password' => Crypt::encryptString($row['password']),
            'role_id'   => ($row['role_id'] == 'dosen') ? 2 : (($row['role_id'] == 'mahasiswa') ? 3 : $row['role_id']),
            'foto'      => 'default.jpg',
            'prodi'     => 'Teknik Informatika',
        ]);
    }
}
