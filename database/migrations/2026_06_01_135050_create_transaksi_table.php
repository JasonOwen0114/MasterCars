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

    $table->foreignId('mobil_id')
        ->nullable()
        ->constrained('mobil');

    $table->foreignId('pembeli_id')
        ->nullable()
        ->constrained('users');

    $table->foreignId('penjual_id')
        ->nullable()
        ->constrained('users');

    $table->bigInteger('harga')->nullable();

    $table->bigInteger('total_komisi')->nullable();

    $table->date('tanggal_transaksi')->nullable();
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
