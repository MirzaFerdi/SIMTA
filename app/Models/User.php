<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public $timestamps = false;

    protected $fillable = [
        'nama',
        'username',
        'password',
        'encrypted_password',
        'email',
        'foto',
        'prodi',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
    public function mahasiswa1Sempro()
    {
        return $this->hasOne(Sempro::class, 'mahasiswa1');
    }
    public function mahasiswa2Sempro()
    {
        return $this->hasOne(Sempro::class, 'mahasiswa2');
    }
    public function dospem1Sempro()
    {
        return $this->hasOne(Sempro::class, 'dospem1');
    }
    public function dospem2Sempro()
    {
        return $this->hasOne(Sempro::class, 'dospem2');
    }


    public function mahasiswa1Pengajuan()
    {
        return $this->hasOne(PengajuanJudul::class, 'mahasiswa1');
    }
    public function mahasiswa2Pengajuan()
    {
        return $this->hasOne(PengajuanJudul::class, 'mahasiswa2');
    }
    public function dospem1Pengajuan()
    {
        return $this->hasOne(PengajuanJudul::class, 'dospem1');
    }
    public function dospem2Pengajuan()
    {
        return $this->hasOne(PengajuanJudul::class, 'dospem2');
    }


    public function mahasiswa1Bimbingan()
    {
        return $this->hasMany(Bimbingan::class, 'mahasiswa1');
    }
    public function mahasiswa2Bimbingan()
    {
        return $this->hasMany(Bimbingan::class, 'mahasiswa2');
    }
    public function dospem1Bimbingan()
    {
        return $this->hasMany(Bimbingan::class, 'dospem1');
    }
    public function dospem2Bimbingan()
    {
        return $this->hasMany(Bimbingan::class, 'dospem2');
    }


    public function mahasiswa1Jadwal()
    {
        return $this->hasMany(Jadwal::class, 'mahasiswa1');
    }
    public function mahasiswa2Jadwal()
    {
        return $this->hasMany(Jadwal::class, 'mahasiswa2');
    }
    public function dosenPenguji1Jadwal()
    {
        return $this->hasMany(Jadwal::class, 'dosen_penguji1');
    }
    public function dosenPenguji2Jadwal()
    {
        return $this->hasMany(Jadwal::class, 'dosen_penguji2');
    }
    public function dospem1Jadwal()
    {
        return $this->hasMany(Jadwal::class, 'dospem1');
    }
    public function dospem2Jadwal()
    {
        return $this->hasMany(Jadwal::class, 'dospem2');
    }


    public function mahasiswa1BeritaAcara()
    {
        return $this->hasMany(BeritaAcara::class, 'mahasiswa1');
    }
    public function mahasiswa2BeritaAcara()
    {
        return $this->hasMany(BeritaAcara::class, 'mahasiswa2');
    }
    public function dosenBeritaAcara()
    {
        return $this->hasMany(BeritaAcara::class, 'dosen');
    }
}
