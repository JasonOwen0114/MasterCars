<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MobilSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('mobil')->insert([
            [
                'id'=>1,'user_id'=>1,'merk'=>'Wuling','nama_mobil'=>'Cortez','tipe'=>'G',
                'tahun'=>2020,'warna'=>'Putih','harga'=>220000000,'kapasitas_kursi'=>7,
                'kapasitas_mesin'=>1500,'transmisi'=>'Automatic','tipe_mesin'=>'Bensin',
                'alamat'=>'Jalan Dharmahusada No.30','status'=>'terjual',
                'foto_thumbnail'=>'mobil/thumbnail1.png','foto_depan'=>'mobil/depan1.png',
                'foto_kanan'=>'mobil/kanan1.png','foto_belakang'=>'mobil/belakang1.png',
                'foto_kiri'=>'mobil/kiri1.png','foto_dashboard'=>'mobil/dashboard1.png',
                'foto_kursi_depan'=>'mobil/kursidepan1.png',
                'foto_kursi_belakang'=>'mobil/kursibelakang1.png',
                'foto_bagasi_belakang'=>'mobil/bagasi1.png',
                'created_at'=>'2025-12-01 10:00:00',
                'updated_at'=>'2026-05-28 22:18:39',
                'kecamatan'=>'Gubeng','status_jual'=>null,
                'kilometer'=>45000,'reinspeksi_used'=>0
            ],
            [
                'id'=>2,'user_id'=>8,'merk'=>'Hyundai','nama_mobil'=>'Santafe','tipe'=>'G',
                'tahun'=>2021,'warna'=>'Hitam','harga'=>450000000,'kapasitas_kursi'=>5,
                'kapasitas_mesin'=>2000,'transmisi'=>'Automatic','tipe_mesin'=>'Diesel',
                'alamat'=>'jalan Lebak Asri No.72','status'=>'terjual',
                'foto_thumbnail'=>'mobil/thumbnail2.png','foto_depan'=>'mobil/depan2.png',
                'foto_kanan'=>'mobil/kanan2.png','foto_belakang'=>'mobil/belakang2.png',
                'foto_kiri'=>'mobil/kiri2.png','foto_dashboard'=>'mobil/dashboard2.png',
                'foto_kursi_depan'=>'mobil/kursidepan2.png',
                'foto_kursi_belakang'=>'mobil/kursibelakang2.png',
                'foto_bagasi_belakang'=>'mobil/bagasi2.png',
                'created_at'=>'2025-12-05 10:00:00',
                'updated_at'=>'2026-05-28 22:18:39',
                'kecamatan'=>'Bubutan','status_jual'=>null,
                'kilometer'=>35000,'reinspeksi_used'=>0
            ],
            [
                'id'=>3,'user_id'=>11,'merk'=>'Kia','nama_mobil'=>'Sorento','tipe'=>'B',
                'tahun'=>2019,'warna'=>'Silver','harga'=>320000000,'kapasitas_kursi'=>5,
                'kapasitas_mesin'=>2000,'transmisi'=>'Automatic','tipe_mesin'=>'Diesel',
                'alamat'=>'Jalan Pucang Asri No.22','status'=>'terjual',
                'foto_thumbnail'=>'mobil/thumbnail3.png','foto_depan'=>'mobil/depan3.png',
                'foto_kanan'=>'mobil/kanan3.png','foto_belakang'=>'mobil/belakang3.png',
                'foto_kiri'=>'mobil/kiri3.png','foto_dashboard'=>'mobil/dashboard3.png',
                'foto_kursi_depan'=>'mobil/kursidepan3.png',
                'foto_kursi_belakang'=>'mobil/kursibelakang3.png',
                'foto_bagasi_belakang'=>'mobil/bagasi3.png',
                'created_at'=>'2025-10-01 10:00:00',
                'updated_at'=>'2026-05-28 22:18:39',
                'kecamatan'=>'Gubeng','status_jual'=>null,
                'kilometer'=>60000,'reinspeksi_used'=>0
            ],
            [
                'id'=>4,'user_id'=>12,'merk'=>'Mitsubishi','nama_mobil'=>'Xpander','tipe'=>'GLS',
                'tahun'=>2022,'warna'=>'Putih','harga'=>260000000,'kapasitas_kursi'=>7,
                'kapasitas_mesin'=>1500,'transmisi'=>'Manual','tipe_mesin'=>'Bensin',
                'alamat'=>'Siwalankerto Permai H21','status'=>'terjual',
                'foto_thumbnail'=>'mobil/thumbnail4.png','foto_depan'=>'mobil/depan4.png',
                'foto_kanan'=>'mobil/kanan4.png','foto_belakang'=>'mobil/belakang4.png',
                'foto_kiri'=>'mobil/kiri4.png','foto_dashboard'=>'mobil/dashboard4.png',
                'foto_kursi_depan'=>'mobil/kursidepan4.png',
                'foto_kursi_belakang'=>'mobil/kursibelakang4.png',
                'foto_bagasi_belakang'=>'mobil/bagasi4.png',
                'created_at'=>'2025-09-15 10:00:00',
                'updated_at'=>'2026-05-28 22:18:39',
                'kecamatan'=>'Bubutan','status_jual'=>null,
                'kilometer'=>25000,'reinspeksi_used'=>0
            ],
            [
                'id'=>5,'user_id'=>13,'merk'=>'Toyota','nama_mobil'=>'Yaris','tipe'=>'S',
                'tahun'=>2021,'warna'=>'Merah','harga'=>240000000,'kapasitas_kursi'=>5,
                'kapasitas_mesin'=>1500,'transmisi'=>'Automatic','tipe_mesin'=>'Bensin',
                'alamat'=>'Jalan Jeruk No.68','status'=>'terjual',
                'foto_thumbnail'=>'mobil/thumbnail5.png','foto_depan'=>'mobil/depan5.png',
                'foto_kanan'=>'mobil/kanan5.png','foto_belakang'=>'mobil/belakang5.png',
                'foto_kiri'=>'mobil/kiri5.png','foto_dashboard'=>'mobil/dashboard5.png',
                'foto_kursi_depan'=>'mobil/kursidepan5.png',
                'foto_kursi_belakang'=>'mobil/kursibelakang5.png',
                'foto_bagasi_belakang'=>'mobil/bagasi5.png',
                'created_at'=>'2026-01-01 10:00:00',
                'updated_at'=>'2026-05-28 22:18:39',
                'kecamatan'=>'Mulyorejo','status_jual'=>null,
                'kilometer'=>30000,'reinspeksi_used'=>0
            ],
            [
                'id'=>6,'user_id'=>1,'merk'=>'BMW','nama_mobil'=>'X1','tipe'=>'-',
                'tahun'=>2020,'warna'=>'Putih','harga'=>520000000,'kapasitas_kursi'=>5,
                'kapasitas_mesin'=>1500,'transmisi'=>'Automatic','tipe_mesin'=>'Bensin',
                'alamat'=>'Jalan Ngagel Jaya Tengah No.23','status'=>'terjual',
                'foto_thumbnail'=>'mobil/thumbnail6.png','foto_depan'=>'mobil/depan6.png',
                'foto_kanan'=>'mobil/kanan6.png','foto_belakang'=>'mobil/belakang6.png',
                'foto_kiri'=>'mobil/kiri6.png','foto_dashboard'=>'mobil/dashboard6.png',
                'foto_kursi_depan'=>'mobil/kursidepan6.png',
                'foto_kursi_belakang'=>'mobil/kursibelakang6.png',
                'foto_bagasi_belakang'=>'mobil/bagasi6.png',
                'created_at'=>'2026-01-15 10:00:00',
                'updated_at'=>'2026-05-28 22:18:39',
                'kecamatan'=>'Gubeng','status_jual'=>null,
                'kilometer'=>40000,'reinspeksi_used'=>0
            ],
            [
                'id'=>7,'user_id'=>8,'merk'=>'Mini Cooper','nama_mobil'=>'Mini','tipe'=>'Premiium',
                'tahun'=>2018,'warna'=>'Kuning','harga'=>480000000,'kapasitas_kursi'=>5,
                'kapasitas_mesin'=>1500,'transmisi'=>'Automatic','tipe_mesin'=>'Bensin',
                'alamat'=>'Jalan Pucang Rinenngo No.22','status'=>'terjual',
                'foto_thumbnail'=>'mobil/thumbnail7.png','foto_depan'=>'mobil/depan7.png',
                'foto_kanan'=>'mobil/kanan7.png','foto_belakang'=>'mobil/belakang7.png',
                'foto_kiri'=>'mobil/kiri7.png','foto_dashboard'=>'mobil/dashboard7.png',
                'foto_kursi_depan'=>'mobil/kursidepan7.png',
                'foto_kursi_belakang'=>'mobil/kursibelakang7.png',
                'foto_bagasi_belakang'=>'mobil/bagasi7.png',
                'created_at'=>'2026-03-01 10:00:00',
                'updated_at'=>'2026-05-28 22:18:39',
                'kecamatan'=>'Mulyorejo','status_jual'=>null,
                'kilometer'=>50000,'reinspeksi_used'=>0
            ],
            [
                'id'=>8,'user_id'=>11,'merk'=>'Toyota','nama_mobil'=>'Avanza','tipe'=>'G',
                'tahun'=>2022,'warna'=>'Hitam','harga'=>210000000,'kapasitas_kursi'=>5,
                'kapasitas_mesin'=>1500,'transmisi'=>'Manual','tipe_mesin'=>'Bensin',
                'alamat'=>'Jalan Boulevard No.33','status'=>'tersedia',
                'foto_thumbnail'=>'mobil/thumbnail8.png','foto_depan'=>'mobil/depan8.png',
                'foto_kanan'=>'mobil/kanan8.png','foto_belakang'=>'mobil/belakang8.png',
                'foto_kiri'=>'mobil/kiri8.png','foto_dashboard'=>'mobil/dashboard8.png',
                'foto_kursi_depan'=>'mobil/kursidepan8.png',
                'foto_kursi_belakang'=>'mobil/kursibelakang8.png',
                'foto_bagasi_belakang'=>'mobil/bagasi8.png',
                'created_at'=>'2026-05-28 22:18:39',
                'updated_at'=>'2026-05-28 22:18:39',
                'kecamatan'=>'Mulyorejo','status_jual'=>null,
                'kilometer'=>20000,'reinspeksi_used'=>0
            ],
            [
                'id'=>9,'user_id'=>12,'merk'=>'Honda','nama_mobil'=>'Civic','tipe'=>'RS',
                'tahun'=>2020,'warna'=>'Putih','harga'=>390000000,'kapasitas_kursi'=>5,
                'kapasitas_mesin'=>2000,'transmisi'=>'Automatic','tipe_mesin'=>'Bensin',
                'alamat'=>'Jalan Dharmahusada No.21','status'=>'tersedia',
                'foto_thumbnail'=>'mobil/thumbnail9.png','foto_depan'=>'mobil/depan9.png',
                'foto_kanan'=>'mobil/kanan9.png','foto_belakang'=>'mobil/belakang9.png',
                'foto_kiri'=>'mobil/kiri9.png','foto_dashboard'=>'mobil/dashboard9.png',
                'foto_kursi_depan'=>'mobil/kursidepan9.png',
                'foto_kursi_belakang'=>'mobil/kursibelakang9.png',
                'foto_bagasi_belakang'=>'mobil/bagasi9.png',
                'created_at'=>'2026-05-28 22:18:39',
                'updated_at'=>'2026-05-28 22:18:39',
                'kecamatan'=>'Gubeng','status_jual'=>null,
                'kilometer'=>45000,'reinspeksi_used'=>0
            ],
            [
                'id'=>10,'user_id'=>13,'merk'=>'Toyota','nama_mobil'=>'Fortuner','tipe'=>'VRZ',
                'tahun'=>2021,'warna'=>'Hitam','harga'=>510000000,'kapasitas_kursi'=>7,
                'kapasitas_mesin'=>2000,'transmisi'=>'Automatic','tipe_mesin'=>'Diesel',
                'alamat'=>'Jalan Florence No.28','status'=>'tersedia',
                'foto_thumbnail'=>'mobil/thumbnail10.png','foto_depan'=>'mobil/depan10.png',
                'foto_kanan'=>'mobil/kanan10.png','foto_belakang'=>'mobil/belakang10.png',
                'foto_kiri'=>'mobil/kiri10.png','foto_dashboard'=>'mobil/dashboard10.png',
                'foto_kursi_depan'=>'mobil/kursidepan10.png',
                'foto_kursi_belakang'=>'mobil/kursibelakang10.png',
                'foto_bagasi_belakang'=>'mobil/bagasi10.png',
                'created_at'=>'2026-05-28 22:18:39',
                'updated_at'=>'2026-05-28 22:18:39',
                'kecamatan'=>null,'status_jual'=>null,
                'kilometer'=>38000,'reinspeksi_used'=>0
            ],
            [
                'id'=>11,'user_id'=>1,'merk'=>'Mitsubishi','nama_mobil'=>'Pajero','tipe'=>'DAKAR',
                'tahun'=>2019,'warna'=>'Silver','harga'=>490000000,'kapasitas_kursi'=>7,
                'kapasitas_mesin'=>2000,'transmisi'=>'Automatic','tipe_mesin'=>'Diesel',
                'alamat'=>'jalan san diego No.29','status'=>'terhapus',
                'foto_thumbnail'=>'mobil/thumbnail11.png','foto_depan'=>'mobil/depan11.png',
                'foto_kanan'=>'mobil/kanan11.png','foto_belakang'=>'mobil/belakang11.png',
                'foto_kiri'=>'mobil/kiri11.png','foto_dashboard'=>'mobil/dashboard11.png',
                'foto_kursi_depan'=>'mobil/kursidepan11.png',
                'foto_kursi_belakang'=>'mobil/kursibelakang11.png',
                'foto_bagasi_belakang'=>'mobil/bagasi11.png',
                'created_at'=>'2026-05-28 22:18:39',
                'updated_at'=>'2026-06-01 06:24:15',
                'kecamatan'=>'Gubeng','status_jual'=>null,
                'kilometer'=>55000,'reinspeksi_used'=>0
            ]
        ]);
    }
}
