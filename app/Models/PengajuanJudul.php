<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanJudul extends Model
{

    public $timestamps = false;

    protected $table = 'pengajuan_juduls';

    protected $fillable = [
        'pengusul1',
        'pengusul2',
        'tahun',
        'judul',
        'status'
    ];

    public function pengusul1Pengajuan(){
        return $this->belongsTo(User::class, 'pengusul1');
    }
    public function pengusul2Pengajuan(){
        return $this->belongsTo(User::class, 'pengusul2');
    }
    public function tugasAkhir(){
        return $this->hasOne(TugasAkhir::class, 'pengajuan_id');
    }
    public function pengajuanSempro(){
        return $this->hasOne(Sempro::class, 'pengajuan_id');
    }
    public function jadwal(){
        return $this->hasMany(Jadwal::class, 'pengajuan_id');
    }

}
