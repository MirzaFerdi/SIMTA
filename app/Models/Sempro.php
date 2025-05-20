<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sempro extends Model
{

    public $timestamps = false;

    protected $table = 'sempros';

    protected $fillable = [
        'pengusul1',
        'pengusul2',
        'pengajuan_id',
        'no_ta',
        'abstrak',
        'status',
        'laporan',
        'ppt',
        'berita_acara'
    ];

    public function pengusul1(){
        return $this->belongsTo(User::class, 'pengusul1');
    }
    public function pengusul2(){
        return $this->belongsTo(User::class, 'pengusul2');
    }
    public function pengajuan(){
        return $this->belongsTo(PengajuanJudul::class, 'pengajuan_id');
    }
}
