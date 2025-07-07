<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeritaAcara extends Model
{
    use HasFactory;

    protected $table = 'berita_acaras';

    protected $fillable = [
        'mahasiswa1',
        'mahasiswa2',
        'dosen',
        'pengajuan_id',
        'berita_acara',
        'status'
    ];

    public $timestamps = false;

    public function mahasiswa1BeritaAcara()
    {
        return $this->belongsTo(User::class, 'mahasiswa1');
    }

    public function mahasiswa2BeritaAcara()
    {
        return $this->belongsTo(User::class, 'mahasiswa2');
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
