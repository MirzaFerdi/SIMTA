<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanJudul extends Model
{

    public $timestamps = false;

    protected $table = 'pengajuan_juduls';

    protected $fillable = [
        'mahasiswa1',
        'mahasiswa2',
        'dospem1',
        'dospem2',
        'tahun',
        'judul',
        'status'
    ];

    public function mahasiswa1Pengajuan(){
        return $this->belongsTo(User::class, 'mahasiswa1');
    }
    public function mahasiswa2Pengajuan(){
        return $this->belongsTo(User::class, 'mahasiswa2');
    }
    public function dospem1Pengajuan(){
        return $this->belongsTo(User::class, 'dospem1');
    }
    public function dospem2Pengajuan(){
        return $this->belongsTo(User::class, 'dospem2');
    }
    public function pengajuanSempro(){
        return $this->hasOne(Sempro::class, 'pengajuan_id');
    }
    public function jadwal(){
        return $this->hasMany(Jadwal::class, 'pengajuan_id');
    }
    public function beritaAcara(){
        return $this->hasOne(BeritaAcara::class, 'pengajuan_id');
    }

}
