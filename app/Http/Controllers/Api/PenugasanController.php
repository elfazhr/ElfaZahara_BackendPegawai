<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Penugasan;
use Illuminate\Http\Request;

class PenugasanController extends Controller
{
    // Menampilkan semua data penugasan
    public function index()
    {
        return Penugasan::all();
    }

    public function getPenugasan()
    {
        // Retrieve all Jabatan data
        $penugasans = Penugasan::all();

        // Format options to be "Jabatan/Golongan/Eselon"
        $formattedPenugasan = $penugasans->map(function ($item) {
            return [
                'label' => "{$item->Tempat_Tugas}/{$item->Unit_Kerja}",
                'value' => $item->ID_Penugasan, // Use id as the unique identifier for the option value
            ];
        });

        // Return formatted response
        return response()->json($formattedPenugasan);
    }

    // Menyimpan data penugasan baru
    public function store(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'Tempat_Tugas' => 'required',
            'Unit_Kerja' => 'required',
        ]);

        $penugasan = Penugasan::create([
            'Tempat_Tugas' => $validated['Tempat_Tugas'],
            'Unit_Kerja' => $validated['Unit_Kerja'],
        ]);

        // Return a response with the created jabatan data
        return response()->json([
            'status' => true,
            'data' => $penugasan,
            'message' => 'Jabatan created successfully!'
        ]);
    }

    // Menampilkan data penugasan berdasarkan ID
    public function show($id)
    {
        return Penugasan::findOrFail($id);
    }

    // Mengupdate data penugasan
    public function update(Request $request, $id)
    {
        $penugasan = Penugasan::findOrFail($id);
        $penugasan->update($request->all());

        return $penugasan;
    }

    // Menghapus data penugasan
    public function destroy($id)
    {
        $penugasan = Penugasan::findOrFail($id);
        $penugasan->delete();

        return response()->json(['message' => 'Data penugasan berhasil dihapus']);
    }
}