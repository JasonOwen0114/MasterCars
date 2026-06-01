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

            $table->unsignedBigInteger('inspeksi_id')->nullable();

            $table->bigInteger('jumlah')->nullable();

            $table->date('tanggal_bayar')->nullable();

            $table->foreign('inspeksi_id', 'fk_biaya_jadwal')
                ->references('id')
                ->on('jadwal_inspeksi')
                ->onDelete('cascade');
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