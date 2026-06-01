<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiMesin extends Model
{
    protected $table = 'inspeksi_mesin';
    public $timestamps = false;
    protected $fillable = [
        'inspeksi_id',

        'suara_mesin','foto_suara_mesin','note_suara_mesin',
        'getaran_mesin','foto_geteran_mesin','note_getaran_mesin',
        'kebocoran_oli','foto_kebocoran_oli','note_kebocoran_oli',
        'asap_knalpot','foto_asap_knalpot','note_asap_knalpot',
        'transmisi','foto_transmisi','note_transmisi',
        'rem','foto_rem','note_rem',
        'power_steering','foto_power_steering','note_power_steering',
        'suspensi','foto_suspensi','note_suspensi',
        'radiator','foto_radiator','note_radiator',
        'aki','foto_aki','note_aki',
        'indikator_dashboard','foto_indikator_dashboard','note_indikator_dashboard',
    ];
}
