<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalBooking extends Model
{
    use HasFactory;

    protected $table = 'jadwal_booking';

    protected $fillable = [
        'mobil_id',
        'order_id',
        'user_id',
        'pembeli_id',
        'staff_id',
        'status',
        'merk',
        'model_mobil',
        'tahun',
        'transmisi',
        'warna',
        'tipe_mesin',
        'nomor_kontak',
        'alamat_asal',
        'kecamatan_asal',
        'alamat_tujuan',
        'kecamatan_tujuan',
        'jadwal',
        'jam',
        'note',
        'kilometer'
    ];

    protected $casts = [
        'jadwal' => 'date',
        'jam' => 'datetime:H:i:s'
    ];




    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function pembeli()
    {
        return $this->belongsTo(User::class, 'pembeli_id');
    }


    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }
}