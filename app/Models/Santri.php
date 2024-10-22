<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Santri extends Model
{
    use HasFactory;

    protected $table = 'santri';
    protected $primaryKey = 'c_santri';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'c_santri', 'nis', 'nama', 'jenis_kelamin', 'tempat_lahir',
        'tanggal_lahir', 'alamat', 'no_telp', 'foto', 'c_kelas', 'c_orangtua'
    ];

    protected $dates = ['tanggal_lahir'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'c_kelas', 'c_kelas');
    }

    public function orangtua()
    {
        return $this->belongsTo(OrangTua::class, 'c_orangtua', 'c_orangtua');
    }

    public function hafalans()
    {
        return $this->hasMany(Hafalan::class, 'nis', 'nis');
    }

    public function prestasis()
    {
        return $this->hasMany(Prestasi::class, 'nis', 'nis');
    }

    public function kegiatans()
    {
        return $this->hasMany(Kegiatan::class, 'nis', 'nis');
    }

    public function pelanggarans()
    {
        return $this->hasMany(Pelanggaran::class, 'nis', 'nis');
    }
}