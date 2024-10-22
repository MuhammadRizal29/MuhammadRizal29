<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hafalan extends Model
{
    use HasFactory;

    protected $table = 'hafalan';
    protected $primaryKey = 'id_hafalan';

    protected $fillable = [
        'nis', 
        'surat', 
        'ayat', 
        'tanggal_mulai', 
        'tanggal_selesai', 
        'guru_pembimbing'
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class, 'nis', 'nis');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_pembimbing', 'c_guru');
    }
}
