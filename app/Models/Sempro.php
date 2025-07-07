<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sempro extends Model
{

    public $timestamps = false;

    protected $table = 'sempros';

    protected $fillable = [
        'mahasiswa1',
        'mahasiswa2',
        'dospem1',
        'dospem2',
        'pengajuan_id',
        'no_ta',
        'abstrak',
        'status',
        'laporan',
        'ppt',
    ];

    public function mahasiswa1Sempro()
    {
        return $this->belongsTo(User::class, 'mahasiswa1');
    }
    public function mahasiswa2Sempro()
    {
        return $this->belongsTo(User::class, 'mahasiswa2');
    }
    public function dospem1Sempro()
    {
        return $this->belongsTo(User::class, 'dospem1');
    }
    public function dospem2Sempro()
    {
        return $this->belongsTo(User::class, 'dospem2');
    }
    public function pengajuanSempro()
    {
        return $this->belongsTo(PengajuanJudul::class, 'pengajuan_id');
    }
}
