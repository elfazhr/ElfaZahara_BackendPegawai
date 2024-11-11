<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;

    protected $table = 'jabatan';
    protected $primaryKey = 'ID_Jabatan';

    protected $fillable = [
        'Jabatan', 'Golongan', 'Eselon'
    ];

    public function pegawai()
    {
        return $this->belongsToMany(Pegawai::class, 'pegawai_jabatan', 'kode_jabatan', 'NIP');
    }
}