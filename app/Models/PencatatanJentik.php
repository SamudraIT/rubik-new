<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PencatatanJentik extends Model
{
    use HasFactory;

    protected $table = 'pencatatan_jentik';

    protected $fillable = [
        'nama_pelapor',
        'lokasi',
        'kepemilikan_ovitrap',
        'tanggal_pelaporan',
        'gambar',
        'kode_pelapor',
        'rw',
        'fasilitas_umum',
        'master_kecamatan_id',
        'master_kelurahan_id',
        'user_id'
    ];

    public function keberadaanJentik(): BelongsTo
    {
        return $this->belongsTo(PencatatanLokasiJentik::class, 'id', 'pencatatan_jentik_id');
    }
}
