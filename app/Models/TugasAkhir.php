<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasAkhir extends Model
{

    public $timestamps = false;

    protected $table = 'tugas_akhirs';

    protected $fillable = [
        'pengusul1',
        'pengusul2',
        'pengajuan_id',
        'no_ta',
        'abstrak',
        'status',
        'laporan',
        'ppt',
        'berita_acara',
        'bimbingan'
    ];
    public function pengusul1TugasAkhir(){
        return $this->belongsTo(User::class, 'pengusul1');
    }
    public function pengusul2TugasAkhir(){
        return $this->belongsTo(User::class, 'pengusul2');
    }
    public function pengajuan(){
        return $this->belongsTo(PengajuanJudul::class, 'pengajuan_id');
    }
}
