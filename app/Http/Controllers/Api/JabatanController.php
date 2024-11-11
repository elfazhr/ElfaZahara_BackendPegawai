<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jabatan;

class JabatanController extends Controller
{

    // Menampilkan semua data jabatan
    public function index()
    {
        return Jabatan::all();
    }

    public function getJabatan()
    {
        // Retrieve all Jabatan data
        $jabatans = Jabatan::all();

        // Format options to be "Jabatan/Golongan/Eselon"
        $formattedJabatans = $jabatans->map(function ($item) {
            return [
                'label' => "{$item->Jabatan}/{$item->Golongan}/{$item->Eselon}",
                'value' => $item->ID_Jabatan, // Use id as the unique identifier for the option value
            ];
        });

        // Return formatted response
        return response()->json($formattedJabatans);
    }


    // Menyimpan data jabatan baru
    public function store(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'Jabatan' => 'required',
            'Golongan' => 'required',
            'Eselon' => 'required',
        ]);

        // Create a new Jabatan using the validated data
        $jabatan = Jabatan::create([
            'Jabatan' => $validated['Jabatan'],
            'Golongan' => $validated['Golongan'],
            'Eselon' => $validated['Eselon'],
        ]);

        // Return a response with the created jabatan data
        return response()->json([
            'status' => true,
            'data' => $jabatan,
            'message' => 'Jabatan created successfully!'
        ]);
    }


    // Menampilkan data jabatan berdasarkan ID
    public function show($id)
    {
        return Jabatan::findOrFail($id);
    }

    // Mengupdate data jabatan
    public function update(Request $request, $id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $jabatan->update($request->all());

        return $jabatan;
    }

    // Menghapus data jabatan
    public function destroy($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $jabatan->delete();

        return response()->json(['message' => 'Data jabatan berhasil dihapus']);
    }
}