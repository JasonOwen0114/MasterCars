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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('mobil_id')->nullable();
            $table->unsignedBigInteger('pembeli_id')->nullable();
            $table->unsignedBigInteger('penjual_id')->nullable();

            $table->bigInteger('harga')->nullable();
            $table->bigInteger('total_komisi')->nullable();

            $table->date('tanggal_transaksi')->nullable();

            $table->foreign('mobil_id')
                ->references('id')
                ->on('mobil');

            $table->foreign('pembeli_id')
                ->references('id')
                ->on('users');

            $table->foreign('penjual_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};