<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pencatatan_lokasi_jentik', function (Blueprint $table) {
            $table->id();
            $table->string('lokasi_jentik');
            $table->string('status_jentik');
            $table->string('kode_pelapor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lokasi_jentik');
    }
};
