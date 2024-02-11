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
        Schema::table('pencatatan_lokasi_jentik', function (Blueprint $table) {
            $table->foreignId('pencatatan_jentik_id')->references('id')->on('pencatatan_jentik')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pencatatan_lokasi_jentik', function (Blueprint $table) {
            $table->foreignId('pencatatan_jentik_id')->references('id')->on('pencatatan_jentik')->cascadeOnDelete();
        });
    }
};
