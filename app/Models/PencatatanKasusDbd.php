<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PencatatanKasusDbd extends Model
{
    use HasFactory;

    protected $table = 'pencatatan_kasus_dbd';

    protected $fillable = [
        'nama_pasien',
        'status_pasien',
        'status_laporan',
        'gejala_penyakit',
        'no_telpon',
        'tanggal_terkonfirmasi',
        'tanggal_sembuh',
        'terkonfirmasi_nakes',
        'master_rumah_sakit_id',
        'master_kecamatan_id',
        'master_kelurahan_id',
        'rw',
        'user_id'
    ];
}
