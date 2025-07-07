<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bimbingan extends Model
{

    public $timestamps = false;

    protected $table = 'bimbingans';

    protected $fillable = [
        'mahasiswa1',
        'mahasiswa2',
        'dospem1',
        'dospem2',
        'tanggal',
        'topik_bimbingan',
        'file',
        'review',
        'status',
    ];

    public function mahasiswa1Bimbingan(){
        return $this->belongsTo(User::class, 'mahasiswa1');
    }

    public function mahasiswa2Bimbingan(){
        return $this->belongsTo(User::class, 'mahasiswa2');
    }

    public function pengajuanJudul1(){
        return $this->belongsTo(PengajuanJudul::class, 'mahasiswa1', 'mahasiswa1');
    }
    public function pengajuanJudul2(){
        return $this->belongsTo(PengajuanJudul::class, 'mahasiswa2', 'mahasiswa2');
    }

    public function dospem1Bimbingan(){
        return $this->belongsTo(User::class, 'dospem1');
    }
    public function dospem2Bimbingan(){
        return $this->belongsTo(User::class, 'dospem2');
    }
}
