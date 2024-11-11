<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawai';
    protected $primaryKey = 'NIP';

    // Memastikan NIP diperlakukan sebagai string
    protected $casts = [
        'NIP' => 'string',
    ];

    protected $fillable = [
        'NIP', 'Nama', 'Tempat_Lahir', 'Alamat', 'Tanggal_Lahir',
        'Jenis_Kelamin', 'Agama', 'NPWP', 'Foto'
    ];

    public function jabatan()
    {
        return $this->belongsToMany(Jabatan::class, 'pegawai_jabatan', 'NIP', 'kode_jabatan');
    }

    public function penugasan()
    {
        return $this->belongsToMany(Penugasan::class, 'pegawai_unit_kerja', 'NIP', 'kode_unit');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($pegawai) {
            // Menghapus data di tabel pivot pegawai_jabatan
            $pegawai->jabatan()->detach();

            // Menghapus data di tabel pivot pegawai_unit_kerja
            $pegawai->penugasan()->detach();
        });
    }
}
