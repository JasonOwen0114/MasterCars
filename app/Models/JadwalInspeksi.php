<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Mobil;
class JadwalInspeksi extends Model
{
    use HasFactory;

    protected $table = 'jadwal_inspeksi';

    protected $fillable = [
        'user_id',
        'staff_id',
        'status',
        'merk',
        'model_mobil',
        'tahun',
        'transmisi',
        'warna',
        'tipe_mesin',
        'nomor_kontak',
        'alamat',
        'kecamatan',
        'jadwal',
        'jam',
        'order_id',
        'kilometer',
        'tipe',
        'mobil_id'
    ];
    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function mobil()
    {
        return $this->belongsTo(Mobil::class);
    }
}
