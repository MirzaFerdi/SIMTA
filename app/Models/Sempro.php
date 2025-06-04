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
        'dospem_id',
        'pengajuan_id',
        'no_ta',
        'abstrak',
        'status',
        'laporan',
        'ppt',
    ];

    public function pengusul1Sempro()
    {
        return $this->belongsTo(User::class, 'pengusul1');
    }
    public function pengusul2Sempro()
    {
        return $this->belongsTo(User::class, 'pengusul2');
    }
    public function dospemSempro()
    {
        return $this->belongsTo(User::class, 'dospem_id');
    }
    public function pengajuanSempro()
    {
        return $this->belongsTo(PengajuanJudul::class, 'pengajuan_id');
    }
}
