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
        'dospem_id',
        'tanggal',
        'topik_bimbingan',
        'status',
    ];

    public function pengusul1Bimbingan(){
        return $this->belongsTo(User::class, 'pengusul1');
    }

    public function pengusul2Bimbingan(){
        return $this->belongsTo(User::class, 'pengusul2');
    }

    public function dospemBimbingan(){
        return $this->belongsTo(User::class, 'dospem_id');
    }
}
