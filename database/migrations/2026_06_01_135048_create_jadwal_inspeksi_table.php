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
Schema::create('jadwal_inspeksi', function (Blueprint $table) {

    $table->id();

    $table->string('order_id')->nullable();

    $table->foreignId('user_id')
        ->nullable()
        ->constrained('users');

    $table->foreignId('staff_id')
        ->nullable()
        ->constrained('users');

    $table->tinyInteger('status')->default(1);

    $table->string('merk', 50)->nullable();
    $table->string('model_mobil', 100)->nullable();

    $table->integer('tahun')->nullable();

    $table->string('transmisi', 30)->nullable();
    $table->string('warna', 30)->nullable();
    $table->string('tipe_mesin', 50)->nullable();

    $table->string('nomor_kontak', 20)->nullable();

    $table->text('alamat')->nullable();

    $table->string('kecamatan', 100)->nullable();

    $table->date('jadwal')->nullable();

    $table->time('jam')->nullable();

    $table->text('note')->nullable();

    $table->integer('kilometer')->nullable();

    $table->foreignId('mobil_id')
        ->nullable()
        ->constrained('mobil');

    $table->string('tipe')->default('inspeksi');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_inspeksi');
    }
};
