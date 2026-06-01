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

    $table->foreignId('inspeksi_id')
        ->nullable()
        ->constrained('inspeksi');

    $items = [
        'suara_mesin',
        'getaran_mesin',
        'kebocoran_oli',
        'asap_knalpot',
        'transmisi',
        'rem',
        'power_steering',
        'suspensi',
        'radiator',
        'aki',
        'indikator_dashboard'
    ];

    foreach ($items as $item) {
        $table->char($item,1)->nullable();
        $table->string('foto_'.$item)->nullable();
        $table->text('note_'.$item)->nullable();
    }
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
