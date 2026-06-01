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
Schema::create('mobil', function (Blueprint $table) {

    $table->id();

    $table->foreignId('user_id')
        ->nullable()
        ->constrained('users');

    $table->string('merk', 50)->nullable();
    $table->string('nama_mobil', 100)->nullable();
    $table->string('tipe', 50)->nullable();

    $table->integer('tahun')->nullable();

    $table->string('warna', 30)->nullable();

    $table->bigInteger('harga')->nullable();

    $table->integer('kapasitas_kursi')->nullable();
    $table->integer('kapasitas_mesin')->nullable();

    $table->string('transmisi', 50)->nullable();
    $table->string('tipe_mesin', 50)->nullable();

    $table->string('alamat', 100)->nullable();

    $table->enum('status', [
        'menunggu',
        'tersedia',
        'terjual',
        'terbooking',
        'terhapus'
    ])->default('menunggu');

    $table->string('foto_thumbnail')->nullable();

    $table->string('foto_depan')->nullable();
    $table->string('foto_kanan')->nullable();
    $table->string('foto_belakang')->nullable();
    $table->string('foto_kiri')->nullable();

    $table->string('foto_dashboard')->nullable();
    $table->string('foto_kursi_depan')->nullable();
    $table->string('foto_kursi_belakang')->nullable();
    $table->string('foto_bagasi_belakang')->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mobil');
    }
};
