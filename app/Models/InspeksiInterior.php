<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiInterior extends Model
{
    protected $table = 'inspeksi_interior';
    public $timestamps = false;
    protected $fillable = [
        'inspeksi_id',

        'kebersihan_kabin','foto_kebersihan_kabin','note_kebersihan_kabin',
        'kondisi_jok','foto_kondisi_jok','note_kondisi_jok',
        'dashboard','foto_dashboard','note_dashboard',
        'audio','foto_audio','note_audio',
        'ac','foto_ac','note_ac',
        'speedometer','foto_speedometer','note_speedometer',
        'karpet','foto_karpet','note_karpet',
        'power_window','foto_power_window','note_power_window',
        'sunroof','foto_sunroof','note_sunroof',
        'sabuk_pengaman','foto_sabuk_pengaman','note_sabuk_pengaman',
        'setir_transmisi','foto_setir_transmisi','note_setir_transmisi',
    ];
}
