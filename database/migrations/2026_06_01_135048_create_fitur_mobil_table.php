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
        ->constrained('mobil')
        ->cascadeOnDelete();

    $table->boolean('abs')->default(false);
    $table->boolean('ebd')->default(false);
    $table->boolean('ba')->default(false);
    $table->boolean('esc')->default(false);
    $table->boolean('tcs')->default(false);
    $table->boolean('hsa')->default(false);
    $table->boolean('hdc')->default(false);
    $table->boolean('vsc')->default(false);
    $table->boolean('ebs')->default(false);

    $table->boolean('isofix')->default(false);
    $table->boolean('immobilizer')->default(false);
    $table->boolean('alarm')->default(false);

    $table->boolean('bsm')->default(false);
    $table->boolean('rcta')->default(false);
    $table->boolean('ldw')->default(false);
    $table->boolean('lka')->default(false);
    $table->boolean('fcw')->default(false);
    $table->boolean('aeb')->default(false);
    $table->boolean('acc')->default(false);

    $table->boolean('tpms')->default(false);
    $table->boolean('camera_360')->default(false);
    $table->boolean('rear_view_camera')->default(false);

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
