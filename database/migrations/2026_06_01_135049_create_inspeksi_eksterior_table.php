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
Schema::create('inspeksi_eksterior', function (Blueprint $table) {

    $table->id();

    $table->foreignId('inspeksi_id')
        ->nullable()
        ->constrained('inspeksi');

    $items = [
        'kondisi_cat',
        'panel_bodi',
        'lampu_depan',
        'lampu_belakang',
        'velg',
        'ban',
        'kaca',
        'wiper'
    ];

    foreach ($items as $item) {
        $table->char($item, 1)->nullable();
        $table->string('foto_'.$item)->nullable();
        $table->text('note_'.$item)->nullable();
    }
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspeksi_eksterior');
    }
};
