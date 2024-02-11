<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MasterKelurahan extends Model
{
    use HasFactory;

    protected $table = "master_kelurahan";

    protected $fillable = [
        'nama',
        'master_kecamatan_id'
    ];

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(MasterKecamatan::class, 'master_kecamatan_id', 'id');
    }
}
