<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BiayaInspeksiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('biaya_inspeksi')->insert([
            [
                'id' => 1,
                'inspeksi_id' => 1,
                'jumlah' => 300000,
                'tanggal_bayar' => '2025-12-10',
            ],
            [
                'id' => 2,
                'inspeksi_id' => 2,
                'jumlah' => 300000,
                'tanggal_bayar' => '2026-01-12',
            ],
            [
                'id' => 3,
                'inspeksi_id' => 3,
                'jumlah' => 300000,
                'tanggal_bayar' => '2025-12-05',
            ],
            [
                'id' => 4,
                'inspeksi_id' => 4,
                'jumlah' => 300000,
                'tanggal_bayar' => '2025-11-15',
            ],
            [
                'id' => 5,
                'inspeksi_id' => 5,
                'jumlah' => 300000,
                'tanggal_bayar' => '2026-02-08',
            ],
            [
                'id' => 6,
                'inspeksi_id' => 6,
                'jumlah' => 300000,
                'tanggal_bayar' => '2026-02-18',
            ],
            [
                'id' => 7,
                'inspeksi_id' => 7,
                'jumlah' => 300000,
                'tanggal_bayar' => '2026-04-03',
            ],
            [
                'id' => 8,
                'inspeksi_id' => 8,
                'jumlah' => 300000,
                'tanggal_bayar' => '2026-05-01',
            ],
            [
                'id' => 9,
                'inspeksi_id' => 9,
                'jumlah' => 300000,
                'tanggal_bayar' => '2026-05-02',
            ],
            [
                'id' => 10,
                'inspeksi_id' => 10,
                'jumlah' => 300000,
                'tanggal_bayar' => '2026-05-03',
            ],
            [
                'id' => 11,
                'inspeksi_id' => 11,
                'jumlah' => 300000,
                'tanggal_bayar' => '2026-05-04',
            ],
            [
                'id' => 66,
                'inspeksi_id' => 140,
                'jumlah' => 300000,
                'tanggal_bayar' => '2026-06-01',
            ],
        ]);
    }
}