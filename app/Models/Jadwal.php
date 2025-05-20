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
        'dospem_id',
        'tanggal',
        'tahun_akademik',
        'jam',
        'tempat',
        'jenis_ujian'
    ];

    public function pengusul1(){
        return $this->belongsTo(User::class, 'pengusul1');
    }

    public function pengusul2(){
        return $this->belongsTo(User::class, 'pengusul2');
    }
    public function dospem(){
        return $this->belongsTo(User::class, 'dospem_id');
    }

    public function pengajuan(){
        return $this->belongsTo(PengajuanJudul::class, 'pengajuan_id');
    }
}
