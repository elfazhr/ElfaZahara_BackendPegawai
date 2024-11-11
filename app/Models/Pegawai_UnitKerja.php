<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai_UnitKerja extends Model
{
    use HasFactory;
    protected $table = 'pegawai_unit_kerja';

    protected $fillable = [
        'NIP', 'kode_unit'
    ];
}