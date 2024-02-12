<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $table = 'user_profile';

    protected $fillable = [
        'no_kk',
        'alamat',
        'status_hunian',
        'rt',
        'rw',
        'user_id',
        'nakes',
        'master_rumah_sakit_id',
        'master_kelurahan_id',
        'master_kecamatan_id'
    ];
}
