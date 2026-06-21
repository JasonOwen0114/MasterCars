<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    protected $table = 'mobil';

    protected $fillable = [
        'user_id',
        'merk',
        'nama_mobil',
        'tipe',
        'tahun',
        'warna',
        'transmisi',
        'kapasitas_kursi',
        'kapasitas_mesin',
        'alamat',
        'kecamatan',
        'harga',
        'status',
        'status_jual',
        'foto_thumbnail',
        'foto_depan',
        'foto_kanan',
        'foto_belakang',
        'foto_kiri',
        'foto_dashboard',
        'foto_kursi_depan',
        'foto_kursi_belakang',
        'foto_bagasi_belakang',
        'kilometer',
        'reinspeksi_used',
        'tipe_mesin',
        'foto_serahterima'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

 
    public function fitur()
    {
        return $this->hasOne(FiturMobil::class);
    }

    public function inspeksi()
    {
        return $this->hasOne(\App\Models\Inspeksi::class, 'mobil_id')->latestOfMany();
    }

}
