<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
Schema::create('fitur_mobil', function (Blueprint $table) {

    $table->id();

    $table->foreignId('mobil_id')
        ->nullable()
        ->constrained('mobil');

    $fitur = [
        'abs','ebd','ba','esc','tcs',
        'hsa','hdc','vsc','ebs','isofix',
        'immobilizer','alarm','bsm',
        'rcta','ldw','lka','fcw',
        'aeb','acc','tpms',
        'camera_360',
        'rear_view_camera'
    ];

    foreach($fitur as $item){
        $table->boolean($item)->default(false);
    }

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fitur_mobil');
    }
};
