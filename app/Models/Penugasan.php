<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penugasan extends Model
{
    use HasFactory;

    protected $table = 'penugasan';
    protected $primaryKey = 'ID_Penugasan';

    protected $fillable = [
        'Tempat_Tugas', 'Unit_Kerja'
    ];

    public function pegawai()
    {
        return $this->belongsToMany(Pegawai::class, 'pegawai_unit_kerja', 'kode_unit', 'NIP');
    }
}