<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bimbingan extends Model
{

    public $timestamps = false;

    protected $table = 'bimbingan';

    protected $fillable = [
        'pengusul1',
        'pengusul2',
        'dospem_id',
        'no_ta',
        'abstrak',
        'status',
        'laporan',
        'ppt',
        'berita_acara',
        'bimbingan'
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
}
