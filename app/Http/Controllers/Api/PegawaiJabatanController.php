<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pegawai_Jabatan;
use Illuminate\Http\Request;

class PegawaiJabatanController extends Controller
{ // Menampilkan daftar pegawai_jabatan
    public function index()
    {
        $pegawaiJabatan = Pegawai_Jabatan::all();
        return response()->json($pegawaiJabatan);
    }

    // Menyimpan data baru ke tabel pegawai_jabatan
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'NIP' => 'required|string',
            'kode_jabatan' => 'required',
        ]);

        $pegawaiJabatan = Pegawai_Jabatan::create($validatedData);
        return response()->json($pegawaiJabatan, 201);
    }

    // Menampilkan data pegawai_jabatan tertentu
    public function show($id)
    {
        $pegawaiJabatan = Pegawai_Jabatan::findOrFail($id);
        return response()->json($pegawaiJabatan);
    }

    // Memperbarui data pegawai_jabatan tertentu
    public function update(Request $request, $id)
    {
        $pegawaiJabatan = Pegawai_Jabatan::findOrFail($id);
        
        $validatedData = $request->validate([
            'NIP' => 'required|string',
            'kode_jabatan' => 'required|string',
        ]);

        $pegawaiJabatan->update($validatedData);
        return response()->json($pegawaiJabatan);
    }

    // Menghapus data pegawai_jabatan tertentu
    public function destroy($id)
    {
        $pegawaiJabatan = Pegawai_Jabatan::findOrFail($id);
        $pegawaiJabatan->delete();

        return response()->json(['message' => 'Pegawai Jabatan deleted successfully']);
    }
}