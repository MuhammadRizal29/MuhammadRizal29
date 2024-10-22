<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';
    protected $primaryKey = 'c_kelas';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'c_kelas', 'nama_kelas', 'tingkat', 'wali_kelas'
    ];

    /**
     * Relasi dengan model Santri.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function santris()
    {
        return $this->hasMany(Santri::class, 'c_kelas', 'c_kelas');
    }

    /**
     * Relasi dengan model Guru (Wali Kelas).
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function waliKelas()
    {
        return $this->belongsTo(Guru::class, 'wali_kelas', 'c_guru');
    }
}