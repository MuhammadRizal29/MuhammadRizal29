<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    protected $table = 'prestasi';
    protected $primaryKey = 'id_prestasi';

    protected $fillable = ['nis', 'jenis_prestasi', 'penyelenggara', 'tanggal', 'peringkat', 'nama_perlombaan']; // Menambahkan nama_perlombaan

    public function santri()
    {
        return $this->belongsTo(Santri::class, 'nis', 'nis');
    }
}
