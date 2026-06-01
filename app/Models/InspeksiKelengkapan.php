<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiKelengkapan extends Model
{
    protected $table = 'inspeksi_kelengkapan';
    public $timestamps = false;
    protected $fillable = [
        'inspeksi_id',

        'stnk','foto_stnk','note_stnk',
        'bpkb','foto_bpkb','note_bpkb',
        'faktur','foto_faktur','note_faktur',
        'surat_pelepasan','foto_surat_pelepasan','note_surat_pelepasan',
        'dokumen_tambahan','foto_dokumen_tambahan','note_dokumen_tambahan',
    ];
}
