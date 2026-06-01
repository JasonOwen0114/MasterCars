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
Schema::create('biaya_inspeksi', function (Blueprint $table) {

    $table->id();

    $table->foreignId('inspeksi_id')
        ->nullable()
        ->constrained('jadwal_inspeksi')
        ->cascadeOnDelete();

    $table->bigInteger('jumlah')->nullable();

    $table->date('tanggal_bayar')->nullable();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biaya_inspeksi');
    }
};
