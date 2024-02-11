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
        Schema::table('pencatatan_kasus_dbd', function (Blueprint $table) {
            $table->foreignId('master_kecamatan_id')->references('id')->on('master_kecamatan')->cascadeOnDelete();
            $table->foreignId('master_kelurahan_id')->references('id')->on('master_kelurahan')->cascadeOnDelete();
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('master_rumah_sakit_id')->references('id')->on('master_rumah_sakit')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pencatatan_kasus_dbd', function (Blueprint $table) {
            $table->foreignId('master_kecamatan_id')->references('id')->on('master_kecamatan')->cascadeOnDelete();
            $table->foreignId('master_kelurahan_id')->references('id')->on('master_kelurahan')->cascadeOnDelete();
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('master_rumah_sakit_id')->references('id')->on('master_rumah_sakit')->cascadeOnDelete();
        });
    }
};
