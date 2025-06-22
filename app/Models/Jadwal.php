<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{

    public $timestamps = false;

    protected $table = 'jadwals';

    protected $fillable = [
        'pengusul1',
        'pengusul2',
        'pengajuan_id',
        'dospem1',
        'dospem2',
        'dosen_penguji1',
        'dosen_penguji2',
        'tanggal',
        'tahun_akademik',
        'jam',
        'tempat',
        'status',
    ];
    public function pengusul1Jadwal(){
        return $this->belongsTo(User::class, 'pengusul1');
    }
    public function pengusul2Jadwal(){
        return $this->belongsTo(User::class, 'pengusul2');
    }
    public function dosenPenguji1Jadwal(){
        return $this->belongsTo(User::class, 'dosen_penguji1');
    }
    public function dosenPenguji2Jadwal(){
        return $this->belongsTo(User::class, 'dosen_penguji2');
    }
    public function pengajuan(){
        return $this->belongsTo(PengajuanJudul::class, 'pengajuan_id');
    }
    public function dospem1Jadwal(){
        return $this->belongsTo(User::class, 'dospem1');
    }
    public function dospem2Jadwal(){
        return $this->belongsTo(User::class, 'dospem2');
    }
}
