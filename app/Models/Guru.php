<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Guru extends Authenticatable
{
    protected $table = 'guru';
    protected $primaryKey = 'c_guru';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'c_guru', 'nip', 'nama', 'jenis_kelamin', 'alamat', 'no_telp', 'email', 'username', 'password', 'foto'
    ];

    protected $hidden = [
        'password',
    ];
}