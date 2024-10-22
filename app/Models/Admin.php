<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admin';
    protected $primaryKey = 'c_admin';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'c_admin', 'nama', 'username', 'password',
    ];

    protected $hidden = [
        'password',
    ];
}