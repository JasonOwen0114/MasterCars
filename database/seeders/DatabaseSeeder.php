<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            MobilSeeder::class,
            JadwalInspeksiSeeder::class,
            InspeksiSeeder::class,
            InspeksiEksteriorSeeder::class,
            InspeksiInteriorSeeder::class,
            InspeksiMesinSeeder::class,
            InspeksiKelengkapanSeeder::class,
            BiayaInspeksiSeeder::class,
            JadwalBookingSeeder::class,
            TransaksiSeeder::class,
            FiturMobilSeeder::class,
            DataMobilSeeder::class,
        ]);
    }
}