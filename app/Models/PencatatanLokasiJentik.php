<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PencatatanLokasiJentik extends Model
{
    use HasFactory;

    protected $table = 'pencatatan_lokasi_jentik';

    protected $fillable = [
        'lokasi_jentik',
        'status_jentik',
        'kode_pelapor',
        'pencatatan_jentik_id'
    ];
}
