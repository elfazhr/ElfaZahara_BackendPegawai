<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pegawai_UnitKerja;
use Illuminate\Http\Request;

class PegawaiPenugasanController extends Controller
{
    public function index()
    {
        $pegawaiUnitKerja = Pegawai_UnitKerja::all();
        return response()->json($pegawaiUnitKerja);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'NIP' => 'required|string',
            'kode_unit' => 'required',
        ]);

        $pegawaiUnitKerja = Pegawai_UnitKerja::create($validatedData);
        return response()->json($pegawaiUnitKerja, 201);
    }

    public function show($id)
    {
        $pegawaiUnitKerja = Pegawai_UnitKerja::findOrFail($id);
        return response()->json($pegawaiUnitKerja);
    }

    public function update(Request $request, $id)
    {
        $pegawaiUnitKerja = Pegawai_UnitKerja::findOrFail($id);
        
        $validatedData = $request->validate([
            'NIP' => 'required|string',
            'kode_unit' => 'required|string',
        ]);

        $pegawaiUnitKerja->update($validatedData);
        return response()->json($pegawaiUnitKerja);
    }

    public function destroy($id)
    {
        $pegawaiUnitKerja = Pegawai_UnitKerja::findOrFail($id);
        $pegawaiUnitKerja->delete();

        return response()->json(['message' => 'Pegawai Unit Kerja deleted successfully']);
    }
}