<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiEksterior extends Model
{
    protected $table = 'inspeksi_eksterior';
    public $timestamps = false;
    protected $fillable = [
        'inspeksi_id',
        'kondisi_cat','foto_kondisi_cat','note_kondisi_cat',
        'panel_bodi','foto_panel_bodi','note_panel_bodi',
        'lampu_depan','foto_lampu_depan','note_lampu_depan',
        'lampu_belakang','foto_lampu_belakang','note_lampu_belakang',
        'velg','foto_velg','note_velg',
        'ban','foto_ban','note_ban',
        'kaca','foto_kaca','note_kaca',
        'wiper','foto_wiper','note_wiper',
    ];

    public function inspeksi()
    {
        return $this->belongsTo(Inspeksi::class);
    }
}
