<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inspeksi extends Model
{
    protected $table = 'inspeksi';

    protected $fillable = [
        'mobil_id',
        'staff_id',
        'tanggal_inspeksi',
        'catatan',
        'grade_eksterior',
        'grade_interior',
        'grade_mesin',
        'grade_kelengkapan',
        'grade_keseluruhan',
    ];

    public function mobil()
    {
        return $this->belongsTo(Mobil::class);
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function eksterior()
    {
        return $this->hasOne(InspeksiEksterior::class);
    }

    public function interior()
    {
        return $this->hasOne(InspeksiInterior::class);
    }

    public function mesin()
    {
        return $this->hasOne(InspeksiMesin::class);
    }

    public function kelengkapan()
    {
        return $this->hasOne(InspeksiKelengkapan::class);
    }
    public function fiturMobil()
{
    return $this->hasOne(FiturMobil::class, 'mobil_id', 'mobil_id');
}
}
