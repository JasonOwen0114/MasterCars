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
        Schema::create('inspeksi_interior', function (Blueprint $table) {

            $table->id();

            $table->foreignId('inspeksi_id')
                ->nullable()
                ->constrained('inspeksi')
                ->nullOnDelete();

           
            $table->char('dashboard', 1)->nullable();
            $table->string('foto_dashboard')->nullable();
            $table->text('note_dashboard')->nullable();

          
            $table->char('jok_depan', 1)->nullable();
            $table->string('foto_jok_depan')->nullable();
            $table->text('note_jok_depan')->nullable();

        
            $table->char('jok_belakang', 1)->nullable();
            $table->string('foto_jok_belakang')->nullable();
            $table->text('note_jok_belakang')->nullable();

            $table->char('plafon', 1)->nullable();
            $table->string('foto_plafon')->nullable();
            $table->text('note_plafon')->nullable();

      
            $table->char('karpet', 1)->nullable();
            $table->string('foto_karpet')->nullable();
            $table->text('note_karpet')->nullable();

        
            $table->char('door_trim', 1)->nullable();
            $table->string('foto_door_trim')->nullable();
            $table->text('note_door_trim')->nullable();

       
            $table->char('audio', 1)->nullable();
            $table->string('foto_audio')->nullable();
            $table->text('note_audio')->nullable();

    
            $table->char('ac', 1)->nullable();
            $table->string('foto_ac')->nullable();
            $table->text('note_ac')->nullable();

  
            $table->char('power_window', 1)->nullable();
            $table->string('foto_power_window')->nullable();
            $table->text('note_power_window')->nullable();

       
            $table->char('panel_instrumen', 1)->nullable();
            $table->string('foto_panel_instrumen')->nullable();
            $table->text('note_panel_instrumen')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspeksi_interior');
    }
};