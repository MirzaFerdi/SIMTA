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
    public function pengusul1Sempro()
    {
        return $this->hasOne(Sempro::class, 'pengusul1');
    }
    public function pengusul2Sempro()
    {
        return $this->hasOne(Sempro::class, 'pengusul2');
    }
    public function dospemSempro()
    {
        return $this->hasOne(Sempro::class, 'dospem_id');
    }


    public function pengusul1Pengajuan()
    {
        return $this->hasOne(PengajuanJudul::class, 'pengusul1');
    }
    public function pengusul2Pengajuan()
    {
        return $this->hasOne(PengajuanJudul::class, 'pengusul2');
    }


    public function pengusul1Bimbingan()
    {
        return $this->hasMany(Bimbingan::class, 'pengusul1');
    }
    public function pengusul2Bimbingan()
    {
        return $this->hasMany(Bimbingan::class, 'pengusul2');
    }
    public function dospem1Bimbingan()
    {
        return $this->hasMany(Bimbingan::class, 'dospem1');
    }
    public function dospem2Bimbingan()
    {
        return $this->hasMany(Bimbingan::class, 'dospem2');
    }


    public function pengusul1Jadwal()
    {
        return $this->hasMany(Jadwal::class, 'pengusul1');
    }
    public function pengusul2Jadwal()
    {
        return $this->hasMany(Jadwal::class, 'pengusul2');
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


    public function pengusul1BeritaAcara()
    {
        return $this->hasMany(BeritaAcara::class, 'pengusul1');
    }
    public function pengusul2BeritaAcara()
    {
        return $this->hasMany(BeritaAcara::class, 'pengusul2');
    }
    public function dosenBeritaAcara()
    {
        return $this->hasMany(BeritaAcara::class, 'dosen');
    }
}
