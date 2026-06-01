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
        Schema::create('inspeksi_eksterior', function (Blueprint $table) {

            $table->id();

            $table->foreignId('inspeksi_id')
                ->nullable()
                ->constrained('inspeksi')
                ->nullOnDelete();

       
            $table->char('kondisi_cat', 1)->nullable();
            $table->string('foto_kondisi_cat')->nullable();
            $table->text('note_kondisi_cat')->nullable();

    
            $table->char('panel_bodi', 1)->nullable();
            $table->string('foto_panel_bodi')->nullable();
            $table->text('note_panel_bodi')->nullable();

          
            $table->char('lampu_depan', 1)->nullable();
            $table->string('foto_lampu_depan')->nullable();
            $table->text('note_lampu_depan')->nullable();

       
            $table->char('lampu_belakang', 1)->nullable();
            $table->string('foto_lampu_belakang')->nullable();
            $table->text('note_lampu_belakang')->nullable();

     
            $table->char('velg', 1)->nullable();
            $table->string('foto_velg')->nullable();
            $table->text('note_velg')->nullable();

     
            $table->char('ban', 1)->nullable();
            $table->string('foto_ban')->nullable();
            $table->text('note_ban')->nullable();

       
            $table->char('kaca', 1)->nullable();
            $table->string('foto_kaca')->nullable();
            $table->text('note_kaca')->nullable();

     
            $table->char('wiper', 1)->nullable();
            $table->string('foto_wiper')->nullable();
            $table->text('note_wiper')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspeksi_eksterior');
    }
};