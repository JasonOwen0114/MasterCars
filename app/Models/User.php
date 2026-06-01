<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

protected $fillable = [
    'nama',
    'email',
    'password',
    'no_hp',
    'alamat',
    'kecamatan',
    'role',
];
    protected $hidden = [
        'password'
    ];
public function jadwalInspeksi()
{
    return $this->hasMany(JadwalInspeksi::class,'staff_id');
}
public function jadwalSebagaiStaff()
{
    return $this->hasMany(JadwalInspeksi::class, 'staff_id');
}



}
