<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

public function up(): void
{
    if (Schema::hasTable('users')) {
        return;
    }

    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('nama', 100);
        $table->string('email', 100);
        $table->string('password')->nullable();
        $table->string('no_hp', 20)->nullable();
        $table->tinyInteger('role')->nullable();
        $table->string('alamat')->nullable();
        $table->string('kecamatan')->nullable();
        $table->timestamps();
    });
}
