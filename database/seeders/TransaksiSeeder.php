<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransaksiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('transaksi')->insert([
            [
                'id' => 1,
                'mobil_id' => 1,
                'pembeli_id' => 8,
                'penjual_id' => 1,
                'harga' => 210000000,
                'total_komisi' => 5000000,
                'tanggal_transaksi' => '2026-01-20',
            ],
            [
                'id' => 2,
                'mobil_id' => 2,
                'pembeli_id' => 11,
                'penjual_id' => 8,
                'harga' => 350000000,
                'total_komisi' => 5000000,
                'tanggal_transaksi' => '2026-01-25',
            ],
            [
                'id' => 3,
                'mobil_id' => 3,
                'pembeli_id' => 12,
                'penjual_id' => 11,
                'harga' => 320000000,
                'total_komisi' => 5000000,
                'tanggal_transaksi' => '2025-12-28',
            ],
            [
                'id' => 4,
                'mobil_id' => 4,
                'pembeli_id' => 13,
                'penjual_id' => 12,
                'harga' => 250000000,
                'total_komisi' => 5000000,
                'tanggal_transaksi' => '2025-11-18',
            ],
            [
                'id' => 5,
                'mobil_id' => 5,
                'pembeli_id' => 1,
                'penjual_id' => 13,
                'harga' => 180000000,
                'total_komisi' => 5000000,
                'tanggal_transaksi' => '2026-02-15',
            ],
            [
                'id' => 6,
                'mobil_id' => 6,
                'pembeli_id' => 8,
                'penjual_id' => 1,
                'harga' => 450000000,
                'total_komisi' => 5000000,
                'tanggal_transaksi' => '2026-02-22',
            ],
            [
                'id' => 7,
                'mobil_id' => 7,
                'pembeli_id' => 11,
                'penjual_id' => 8,
                'harga' => 550000000,
                'total_komisi' => 5000000,
                'tanggal_transaksi' => '2026-04-12',
            ],
        ]);
    }
}