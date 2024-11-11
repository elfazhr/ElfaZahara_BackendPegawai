<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai_Jabatan extends Model
{
    use HasFactory;
    protected $table = 'pegawai_jabatan';

    protected $fillable = [
        'NIP',
        'kode_jabatan'
    ];
}