<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reinspeksi extends Model
{
    protected $table = 'reinspeksi';

    protected $fillable = [
        'mobil_id',
        'user_id',
        'jadwal_id',
        'inspeksi_id',
        'status'
    ];

    public function mobil(){
        return $this->belongsTo(Mobil::class);
    }

    public function inspeksi()
    {
        return $this->belongsTo(\App\Models\Inspeksi::class, 'inspeksi_id');
    }
}