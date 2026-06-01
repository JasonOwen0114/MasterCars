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
Schema::create('jadwal_booking', function (Blueprint $table) {

    $table->id();

    $table->foreignId('mobil_id')
        ->nullable()
        ->constrained('mobil');

    $table->string('order_id')->nullable();

    $table->unsignedBigInteger('user_id')->nullable();
    $table->unsignedBigInteger('pembeli_id')->nullable();
    $table->unsignedBigInteger('staff_id')->nullable();

    $table->integer('status')->default(0);

    $table->string('merk',100)->nullable();
    $table->string('model_mobil',100)->nullable();

    $table->integer('tahun')->nullable();

    $table->string('transmisi',50)->nullable();
    $table->string('warna',50)->nullable();
    $table->string('tipe_mesin',50)->nullable();

    $table->string('nomor_kontak',20)->nullable();

    $table->text('alamat_asal')->nullable();
    $table->string('kecamatan_asal')->nullable();

    $table->text('alamat_tujuan')->nullable();
    $table->string('kecamatan_tujuan')->nullable();

    $table->date('jadwal')->nullable();

    $table->time('jam')->nullable();

    $table->text('note')->nullable();

    $table->integer('kilometer')->nullable();

    $table->timestamps();

    $table->foreign('user_id')->references('id')->on('users');
    $table->foreign('pembeli_id')->references('id')->on('users');
    $table->foreign('staff_id')->references('id')->on('users');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_booking');
    }
};
