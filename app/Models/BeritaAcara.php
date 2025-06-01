<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeritaAcara extends Model
{
    use HasFactory;

    protected $table = 'berita_acaras';

    protected $fillable = [
        'pengusul1',
        'pengusul2',
        'dosen',
        'pengajuan_id',
        'berita_acara',
        'status'
    ];

    public $timestamps = false;

    public function pengusul1BeritaAcara()
    {
        return $this->belongsTo(User::class, 'pengusul1');
    }

    public function pengusul2BeritaAcara()
    {
        return $this->belongsTo(User::class, 'pengusul2');
    }

    public function dosenBeritaAcara()
    {
        return $this->belongsTo(User::class, 'dosen');
    }

    public function pengajuanBeritaAcara()
    {
        return $this->belongsTo(PengajuanJudul::class, 'pengajuan_id');
    }
}
