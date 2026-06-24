<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FiturMobil extends Model
{
    protected $table = 'fitur_mobil';

    protected $fillable = [
        'mobil_id',
        'abs',
        'ebd',
        'ba',
        'esc',
        'tcs',
        'hsa',
        'hdc',
        'vsc',
        'ebs',
        'isofix',
        'immobilizer',
        'alarm',
        'bsm',
        'rcta',
        'ldw',
        'lka',
        'fcw',
        'aeb',
        'acc',
        'tpms',
        'camera_360',
        'rear_view_camera',
        'note',
    ];

    public function mobil()
    {
        return $this->belongsTo(Mobil::class);
    }
}