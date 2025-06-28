<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bimbingan extends Model
{

    public $timestamps = false;

    protected $table = 'bimbingans';

    protected $fillable = [
        'pengusul1',
        'pengusul2',
        'dospem1',
        'dospem2',
        'tanggal',
        'topik_bimbingan',
        'file',
        'review',
        'status',
    ];

    public function pengusul1Bimbingan(){
        return $this->belongsTo(User::class, 'pengusul1');
    }

    public function pengusul2Bimbingan(){
        return $this->belongsTo(User::class, 'pengusul2');
    }

    public function pengajuanJudul1(){
        return $this->belongsTo(PengajuanJudul::class, 'pengusul1', 'pengusul1');
    }
    public function pengajuanJudul2(){
        return $this->belongsTo(PengajuanJudul::class, 'pengusul2', 'pengusul2');
    }

    public function dospem1Bimbingan(){
        return $this->belongsTo(User::class, 'dospem1');
    }
    public function dospem2Bimbingan(){
        return $this->belongsTo(User::class, 'dospem2');
    }
}
