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
        Schema::create('inspeksi_kelengkapan', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('inspeksi_id')->nullable();

            $table->char('stnk', 1)->nullable();
            $table->string('foto_stnk')->nullable();
            $table->text('note_stnk')->nullable();

            $table->char('bpkb', 1)->nullable();
            $table->string('foto_bpkb')->nullable();
            $table->text('note_bpkb')->nullable();

            $table->char('faktur', 1)->nullable();
            $table->string('foto_faktur')->nullable();
            $table->text('note_faktur')->nullable();

            $table->char('surat_pelepasan', 1)->nullable();
            $table->string('foto_surat_pelepasan')->nullable();
            $table->text('note_surat_pelepasan')->nullable();

            $table->char('dokumen_tambahan', 1)->nullable();
            $table->string('foto_dokumen_tambahan')->nullable();
            $table->text('note_dokumen_tambahan')->nullable();

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
        Schema::dropIfExists('inspeksi_kelengkapan');
    }
};