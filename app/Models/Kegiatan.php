<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    protected $table = 'kegiatan';
    protected $primaryKey = 'id_kegiatan';


    protected $fillable = [
        'nama_kegiatan', 'jenis_kegiatan', 'tanggal', 'tempat', 'deskripsi', 'waktu'
    ];

    protected $dates = ['tanggal'];

    protected $casts = [
        'waktu' => 'datetime:H:i', 
    ];
}
