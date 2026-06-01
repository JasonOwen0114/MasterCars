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
        Schema::create('inspeksi_mesin', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('inspeksi_id')->nullable();

            $table->char('suara_mesin', 1)->nullable();
            $table->string('foto_suara_mesin')->nullable();
            $table->text('note_suara_mesin')->nullable();

            $table->char('getaran_mesin', 1)->nullable();
            $table->string('foto_getaran_mesin')->nullable();
            $table->text('note_getaran_mesin')->nullable();

            $table->char('kebocoran_oli', 1)->nullable();
            $table->string('foto_kebocoran_oli')->nullable();
            $table->text('note_kebocoran_oli')->nullable();

            $table->char('asap_knalpot', 1)->nullable();
            $table->string('foto_asap_knalpot')->nullable();
            $table->text('note_asap_knalpot')->nullable();

            $table->char('transmisi', 1)->nullable();
            $table->string('foto_transmisi')->nullable();
            $table->text('note_transmisi')->nullable();

            $table->char('rem', 1)->nullable();
            $table->string('foto_rem')->nullable();
            $table->text('note_rem')->nullable();

            $table->char('power_steering', 1)->nullable();
            $table->string('foto_power_steering')->nullable();
            $table->text('note_power_steering')->nullable();

            $table->char('suspensi', 1)->nullable();
            $table->string('foto_suspensi')->nullable();
            $table->text('note_suspensi')->nullable();

            $table->char('radiator', 1)->nullable();
            $table->string('foto_radiator')->nullable();
            $table->text('note_radiator')->nullable();

            $table->char('aki', 1)->nullable();
            $table->string('foto_aki')->nullable();
            $table->text('note_aki')->nullable();

            $table->char('indikator_dashboard', 1)->nullable();
            $table->string('foto_indikator_dashboard')->nullable();
            $table->text('note_indikator_dashboard')->nullable();

            $table->foreign('inspeksi_id')
                ->references('id')
                ->on('inspeksi')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspeksi_mesin');
    }
};