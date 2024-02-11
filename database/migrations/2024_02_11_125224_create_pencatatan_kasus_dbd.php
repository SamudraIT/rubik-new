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
        Schema::create('pencatatan_kasus_dbd', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pasien');
            $table->string('status_pasien');
            $table->string('status_laporan');
            $table->string('gejala_penyakit');
            $table->string('no_telpon');
            $table->date('tanggal_terkonfirmasi');
            $table->date('tanggal_sembuh');
            $table->string('rw')->nullable();
            $table->boolean('terkonfirmasi_nakes')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pencatatan_kasus_dbd');
    }
};
