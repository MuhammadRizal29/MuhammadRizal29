<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class OrangTua extends Authenticatable
{
    protected $table = 'orangtua';
    protected $primaryKey = 'c_orangtua';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'c_orangtua', 'nama', 'jenis_kelamin', 'alamat', 'no_telp', 'pekerjaan', 'hubungan_dengan_santri', 'username', 'password'
    ];

    protected $hidden = [
        'password',
    ];
}