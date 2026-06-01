<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'nama' => 'user1',
                'email' => 'user1@gmail.com',
                'password' => '$2y$12$EFaCaFkiBgNbRusDd31DS.qXIpGfv0d4KFZN7IovxbTexZSzMNB0a',
                'no_hp' => '081222222222',
                'role' => 3,
                'created_at' => '2026-01-30 08:22:41',
                'updated_at' => '2026-05-14 17:23:10',
                'alamat' => 'Pucang Anom No.68',
                'kecamatan' => 'Kertajaya',
            ],
            [
                'id' => 2,
                'nama' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => '$2y$12$L/LxwY9dTbYAL4INCky7huPPVCTpdEbQicyde4C1xFdNDABzBByPi',
                'no_hp' => '081234567890',
                'role' => 1,
                'created_at' => '2026-01-30 15:38:56',
                'updated_at' => '2026-01-30 15:38:56',
                'alamat' => null,
                'kecamatan' => null,
            ],
            [
                'id' => 3,
                'nama' => 'Staff1',
                'email' => 'staff1@gmail.com',
                'password' => '$2y$12$dibmftrvMxPDzy81bE5OQ.6tf9QTPkMb4.3CePCtMnc0u8GHaj7pe',
                'no_hp' => '081234567891',
                'role' => 2,
                'created_at' => '2026-01-30 15:38:56',
                'updated_at' => '2026-01-30 15:38:56',
                'alamat' => null,
                'kecamatan' => null,
            ],
            [
                'id' => 8,
                'nama' => 'user2',
                'email' => 'user2@gmail.com',
                'password' => '$2y$12$StqCZ.DaQelFMFdfTUdel..vpVaGBrCrV9ScBmM9Ry/YLzwECbqKS',
                'no_hp' => '085678937684',
                'role' => 3,
                'created_at' => '2026-04-22 18:48:11',
                'updated_at' => '2026-04-22 18:48:11',
                'alamat' => null,
                'kecamatan' => null,
            ],
            [
                'id' => 9,
                'nama' => 'staff2',
                'email' => 'staff2@gmail.com',
                'password' => '$2y$12$iQo85H5EyUKC//0OOZle5OjpYuK.3eSkYohV0aHpZRUDn0IualHwC',
                'no_hp' => '081234356890',
                'role' => 2,
                'created_at' => '2026-04-22 18:48:44',
                'updated_at' => '2026-04-22 18:48:44',
                'alamat' => 'Pucang Rinenggo No.5',
                'kecamatan' => null,
            ],
            [
                'id' => 11,
                'nama' => 'user3',
                'email' => 'user3@gmail.com',
                'password' => '$2y$12$nMYT9tWo0IDrlaZNUQecR.pJHIICD1KmSw//ZJ1EpIC/3s4B0is/i',
                'no_hp' => '081234567890',
                'role' => 3,
                'created_at' => '2026-05-06 06:59:12',
                'updated_at' => '2026-05-06 06:59:12',
                'alamat' => null,
                'kecamatan' => null,
            ],
            [
                'id' => 12,
                'nama' => 'user4',
                'email' => 'user4@gmail.com',
                'password' => '$2y$12$BDeqvyOno8e54EsVu/eAWeuh6i3j37HhUUaYu/1DkBl6M3X0H7fSm',
                'no_hp' => '081234543678',
                'role' => 3,
                'created_at' => '2026-05-06 06:59:35',
                'updated_at' => '2026-05-06 06:59:35',
                'alamat' => null,
                'kecamatan' => null,
            ],
            [
                'id' => 13,
                'nama' => 'user5',
                'email' => 'user5@gmail.com',
                'password' => '$2y$12$SlS4uWsfWZfBfPqFLiU7NO7v/YPdcmpRZyN7YqZzrTMZhnmEZOOCu',
                'no_hp' => '085674895767',
                'role' => 3,
                'created_at' => '2026-05-06 07:00:13',
                'updated_at' => '2026-05-06 07:00:13',
                'alamat' => null,
                'kecamatan' => null,
            ],
            [
                'id' => 14,
                'nama' => 'user6',
                'email' => 'user6@gmail.com',
                'password' => '$2y$12$ZyIm1hD5HtMrbk0eUuLFzuJc136L/0DpRh4qz1eRTmZwIN1.0aanC',
                'no_hp' => '0898767897652',
                'role' => 3,
                'created_at' => '2026-06-01 07:12:05',
                'updated_at' => '2026-06-01 07:14:35',
                'alamat' => 'jalan dimana saja',
                'kecamatan' => 'Gubeng',
            ],
        ]);
    }
}