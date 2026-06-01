<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InspeksiKelengkapanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('inspeksi_kelengkapan')->insert([
            [
                'id' => 1,
                'inspeksi_id' => 1,
                'stnk' => 'A',
                'bpkb' => 'A',
                'faktur' => 'A',
                'surat_pelepasan' => 'A',
                'dokumen_tambahan' => 'A',
            ],
            [
                'id' => 2,
                'inspeksi_id' => 2,
                'stnk' => 'A',
                'bpkb' => 'A',
                'faktur' => 'A',
                'surat_pelepasan' => 'A',
                'dokumen_tambahan' => 'A',
            ],
            [
                'id' => 3,
                'inspeksi_id' => 3,
                'stnk' => 'A',
                'bpkb' => 'A',
                'faktur' => 'A',
                'surat_pelepasan' => 'A',
                'dokumen_tambahan' => 'A',
            ],
            [
                'id' => 4,
                'inspeksi_id' => 4,
                'stnk' => 'A',
                'bpkb' => 'A',
                'faktur' => 'A',
                'surat_pelepasan' => 'A',
                'dokumen_tambahan' => 'A',
            ],
            [
                'id' => 5,
                'inspeksi_id' => 5,
                'stnk' => 'A',
                'bpkb' => 'A',
                'faktur' => 'A',
                'surat_pelepasan' => 'A',
                'dokumen_tambahan' => 'A',
            ],
            [
                'id' => 6,
                'inspeksi_id' => 6,
                'stnk' => 'A',
                'bpkb' => 'A',
                'faktur' => 'A',
                'surat_pelepasan' => 'A',
                'dokumen_tambahan' => 'A',
            ],
            [
                'id' => 7,
                'inspeksi_id' => 7,
                'stnk' => 'A',
                'bpkb' => 'A',
                'faktur' => 'A',
                'surat_pelepasan' => 'A',
                'dokumen_tambahan' => 'A',
            ],
            [
                'id' => 8,
                'inspeksi_id' => 8,
                'stnk' => 'A',
                'bpkb' => 'A',
                'faktur' => 'A',
                'surat_pelepasan' => 'A',
                'dokumen_tambahan' => 'A',
            ],
            [
                'id' => 9,
                'inspeksi_id' => 9,
                'stnk' => 'A',
                'bpkb' => 'A',
                'faktur' => 'A',
                'surat_pelepasan' => 'A',
                'dokumen_tambahan' => 'A',
            ],
            [
                'id' => 10,
                'inspeksi_id' => 10,
                'stnk' => 'A',
                'bpkb' => 'A',
                'faktur' => 'A',
                'surat_pelepasan' => 'A',
                'dokumen_tambahan' => 'A',
            ],
            [
                'id' => 11,
                'inspeksi_id' => 11,
                'stnk' => 'A',
                'bpkb' => 'A',
                'faktur' => 'A',
                'surat_pelepasan' => 'A',
                'dokumen_tambahan' => 'A',
            ],
        ]);
    }
}