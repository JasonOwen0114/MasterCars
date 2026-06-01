<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FiturMobilSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('fitur_mobil')->insert([
            [
                'id'=>1,'mobil_id'=>1,'abs'=>1,'ebd'=>1,'ba'=>1,'esc'=>0,'tcs'=>0,'hsa'=>0,'hdc'=>0,'vsc'=>0,'ebs'=>0,
                'isofix'=>1,'immobilizer'=>1,'alarm'=>1,'bsm'=>0,'rcta'=>0,'ldw'=>0,'lka'=>0,'fcw'=>0,'aeb'=>0,
                'acc'=>0,'tpms'=>1,'camera_360'=>0,'rear_view_camera'=>1,
                'created_at'=>'2026-06-01 13:59:21','updated_at'=>'2026-06-01 13:59:21'
            ],
            [
                'id'=>2,'mobil_id'=>2,'abs'=>1,'ebd'=>1,'ba'=>1,'esc'=>1,'tcs'=>1,'hsa'=>1,'hdc'=>1,'vsc'=>1,'ebs'=>0,
                'isofix'=>1,'immobilizer'=>1,'alarm'=>1,'bsm'=>1,'rcta'=>1,'ldw'=>1,'lka'=>0,'fcw'=>0,'aeb'=>0,
                'acc'=>1,'tpms'=>1,'camera_360'=>1,'rear_view_camera'=>1,
                'created_at'=>'2026-06-01 13:59:21','updated_at'=>'2026-06-01 13:59:21'
            ],
            [
                'id'=>3,'mobil_id'=>3,'abs'=>1,'ebd'=>1,'ba'=>1,'esc'=>1,'tcs'=>1,'hsa'=>0,'hdc'=>0,'vsc'=>1,'ebs'=>0,
                'isofix'=>1,'immobilizer'=>1,'alarm'=>1,'bsm'=>0,'rcta'=>0,'ldw'=>0,'lka'=>0,'fcw'=>0,'aeb'=>0,
                'acc'=>0,'tpms'=>1,'camera_360'=>0,'rear_view_camera'=>1,
                'created_at'=>'2026-06-01 13:59:21','updated_at'=>'2026-06-01 13:59:21'
            ],
            [
                'id'=>4,'mobil_id'=>4,'abs'=>1,'ebd'=>1,'ba'=>0,'esc'=>0,'tcs'=>0,'hsa'=>1,'hdc'=>0,'vsc'=>0,'ebs'=>0,
                'isofix'=>1,'immobilizer'=>1,'alarm'=>1,'bsm'=>0,'rcta'=>0,'ldw'=>0,'lka'=>0,'fcw'=>0,'aeb'=>0,
                'acc'=>0,'tpms'=>1,'camera_360'=>0,'rear_view_camera'=>1,
                'created_at'=>'2026-06-01 13:59:21','updated_at'=>'2026-06-01 13:59:21'
            ],
            [
                'id'=>5,'mobil_id'=>5,'abs'=>1,'ebd'=>1,'ba'=>1,'esc'=>1,'tcs'=>0,'hsa'=>0,'hdc'=>0,'vsc'=>0,'ebs'=>0,
                'isofix'=>1,'immobilizer'=>1,'alarm'=>1,'bsm'=>0,'rcta'=>0,'ldw'=>0,'lka'=>0,'fcw'=>0,'aeb'=>0,
                'acc'=>0,'tpms'=>1,'camera_360'=>0,'rear_view_camera'=>1,
                'created_at'=>'2026-06-01 13:59:21','updated_at'=>'2026-06-01 13:59:21'
            ],
            [
                'id'=>6,'mobil_id'=>6,'abs'=>1,'ebd'=>1,'ba'=>1,'esc'=>1,'tcs'=>1,'hsa'=>1,'hdc'=>1,'vsc'=>1,'ebs'=>1,
                'isofix'=>1,'immobilizer'=>1,'alarm'=>1,'bsm'=>1,'rcta'=>1,'ldw'=>1,'lka'=>1,'fcw'=>1,'aeb'=>1,
                'acc'=>1,'tpms'=>1,'camera_360'=>1,'rear_view_camera'=>1,
                'created_at'=>'2026-06-01 13:59:21','updated_at'=>'2026-06-01 13:59:21'
            ],
            [
                'id'=>7,'mobil_id'=>7,'abs'=>1,'ebd'=>1,'ba'=>1,'esc'=>1,'tcs'=>1,'hsa'=>1,'hdc'=>0,'vsc'=>1,'ebs'=>0,
                'isofix'=>1,'immobilizer'=>1,'alarm'=>1,'bsm'=>1,'rcta'=>1,'ldw'=>0,'lka'=>0,'fcw'=>0,'aeb'=>0,
                'acc'=>0,'tpms'=>1,'camera_360'=>1,'rear_view_camera'=>1,
                'created_at'=>'2026-06-01 13:59:21','updated_at'=>'2026-06-01 13:59:21'
            ],
            [
                'id'=>8,'mobil_id'=>8,'abs'=>1,'ebd'=>1,'ba'=>0,'esc'=>0,'tcs'=>0,'hsa'=>1,'hdc'=>0,'vsc'=>0,'ebs'=>0,
                'isofix'=>1,'immobilizer'=>1,'alarm'=>1,'bsm'=>0,'rcta'=>0,'ldw'=>0,'lka'=>0,'fcw'=>0,'aeb'=>0,
                'acc'=>0,'tpms'=>1,'camera_360'=>0,'rear_view_camera'=>1,
                'created_at'=>'2026-06-01 13:59:21','updated_at'=>'2026-06-01 13:59:21'
            ],
            [
                'id'=>9,'mobil_id'=>9,'abs'=>1,'ebd'=>1,'ba'=>1,'esc'=>1,'tcs'=>1,'hsa'=>1,'hdc'=>0,'vsc'=>1,'ebs'=>0,
                'isofix'=>1,'immobilizer'=>1,'alarm'=>1,'bsm'=>1,'rcta'=>1,'ldw'=>1,'lka'=>1,'fcw'=>1,'aeb'=>0,
                'acc'=>1,'tpms'=>1,'camera_360'=>1,'rear_view_camera'=>1,
                'created_at'=>'2026-06-01 13:59:21','updated_at'=>'2026-06-01 13:59:21'
            ],
            [
                'id'=>10,'mobil_id'=>10,'abs'=>1,'ebd'=>1,'ba'=>1,'esc'=>1,'tcs'=>1,'hsa'=>1,'hdc'=>1,'vsc'=>1,'ebs'=>1,
                'isofix'=>1,'immobilizer'=>1,'alarm'=>1,'bsm'=>1,'rcta'=>1,'ldw'=>1,'lka'=>1,'fcw'=>1,'aeb'=>1,
                'acc'=>1,'tpms'=>1,'camera_360'=>1,'rear_view_camera'=>1,
                'created_at'=>'2026-06-01 13:59:21','updated_at'=>'2026-06-01 13:59:21'
            ],
            [
                'id'=>11,'mobil_id'=>11,'abs'=>1,'ebd'=>1,'ba'=>1,'esc'=>1,'tcs'=>1,'hsa'=>1,'hdc'=>1,'vsc'=>1,'ebs'=>0,
                'isofix'=>1,'immobilizer'=>1,'alarm'=>1,'bsm'=>1,'rcta'=>0,'ldw'=>0,'lka'=>0,'fcw'=>0,'aeb'=>0,
                'acc'=>0,'tpms'=>1,'camera_360'=>1,'rear_view_camera'=>1,
                'created_at'=>'2026-06-01 13:59:21','updated_at'=>'2026-06-01 13:59:21'
            ]
        ]);
    }
}

