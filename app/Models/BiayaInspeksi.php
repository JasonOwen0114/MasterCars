<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BiayaInspeksi extends Model
{
    protected $table = 'biaya_inspeksi';

    protected $fillable = [
        'inspeksi_id',
        'jumlah',
        'tanggal_bayar',
    ];

    public $timestamps = false;
}
