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
        Schema::create('inspeksi', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('mobil_id')->nullable();
            $table->unsignedBigInteger('staff_id')->nullable();

            $table->char('grade_eksterior', 1)->nullable();
            $table->char('grade_interior', 1)->nullable();
            $table->char('grade_mesin', 1)->nullable();
            $table->char('grade_kelengkapan', 1)->nullable();
            $table->char('grade_keseluruhan', 1)->nullable();

            $table->text('catatan')->nullable();

            $table->date('tanggal_inspeksi')->nullable();

            $table->timestamps();

            $table->foreign('mobil_id')
                ->references('id')
                ->on('mobil')
                ->onDelete('cascade');

            $table->foreign('staff_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspeksi');
    }
};