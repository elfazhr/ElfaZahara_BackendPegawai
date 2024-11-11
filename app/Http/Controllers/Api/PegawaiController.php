<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class PegawaiController extends Controller
{
    public function index()
    {
        // Get all employees
        $data = Pegawai::all();

        // Map the data to include the image URL
        $data = $data->map(function ($item) {
            $item->Foto = url('storage/' . $item->Foto); // Modify the Foto to include full URL
            return $item;
        });


        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    //getAllDataRelasi
    public function getAllPegawaiData(Request $request)
    {
        // Ambil filter unit kerja jika ada
        $unitKerja = $request->input('ID_Penugasan');
        $searchQuery = $request->input('searchQuery');  // Ambil parameter pencarian

        // Query untuk mengambil data pegawai
        $pegawaiQuery = DB::table('pegawai as p')
            ->leftJoin('pegawai_jabatan as pj', 'p.NIP', '=', 'pj.NIP')
            ->leftJoin('jabatan as j', 'pj.Kode_Jabatan', '=', 'j.ID_Jabatan')
            ->leftJoin('pegawai_unit_kerja as pu', 'p.NIP', '=', 'pu.NIP')
            ->leftJoin('penugasan as pen', 'pu.Kode_unit', '=', 'pen.ID_Penugasan')
            ->select(
                'p.NIP',
                'p.Nama',
                'p.Foto',
                'p.Alamat',
                'p.Jenis_Kelamin',
                'p.Tempat_Lahir',
                'p.Tanggal_Lahir',
                'p.Agama',
                'p.NPWP',
                'j.ID_Jabatan',
                'j.Jabatan',
                'j.Golongan',
                'j.Eselon',
                'pen.ID_Penugasan',
                'pen.Tempat_Tugas',
                'pen.Unit_Kerja'
            );

        // Filter berdasarkan unit kerja jika ada
        if ($unitKerja) {
            $pegawaiQuery->where('pen.ID_Penugasan', $unitKerja);
        }

        // Filter berdasarkan query pencarian (NIP atau Nama)
        if ($searchQuery) {
            $pegawaiQuery->where(function ($query) use ($searchQuery) {
                $query->where('p.Nama', 'like', '%' . $searchQuery . '%');
            });
        }

        // Hitung jumlah total pegawai setelah filter
        $totalPegawai = $pegawaiQuery->count();

        // Ambil data pegawai dengan paginasi
        $pegawai = $pegawaiQuery
            ->get()
            ->map(function ($item) {
                // Mengubah nilai Foto menjadi URL lengkap
                $item->Foto = url('storage/' . $item->Foto);
                return $item;
            });

        return response()->json([
            'status' => true,
            'data' => $pegawai,
            'total_pegawai' => $totalPegawai
        ]);
    }




    public function store(Request $request)
    {
        $data = new Pegawai;

        $rules = [
            'NIP' => 'required|string|',
            'Nama' => 'required|string',
            'Tempat_Lahir' => 'required|string',
            'Alamat' => 'required|string',
            'Tanggal_Lahir' => 'required|date',
            'Jenis_Kelamin' => 'required|in:L,P',
            'Agama' => 'required|string',
            'NPWP' => 'required|string',
            'Foto' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal Menambahkan Data, Periksa Validasi Anda',
                'data' => $validator->errors()
            ], 500);
        }

        // Handle Foto upload
        if ($request->hasFile('Foto')) {
            $file = $request->file('Foto');
            // Memeriksa ukuran gambar
            if ($file->getSize() > 2097152) { // Perbaiki kondisi ini
                return response()->json([
                    'status' => false,
                    'message' => 'Ukuran gambar terlalu besar. Maksimum 2000 KB.'
                ], 500);
            }
            // Simpan gambar jika validasi berhasil
            $gambarPath = $file->store('', 'public');
            $gambar = $gambarPath;
        } else {
            $gambar = null;
        }

        // Create a new employee record
        $data->NIP = $request->NIP;
        $data->Nama = $request->Nama;
        $data->Tempat_Lahir = $request->Tempat_Lahir;
        $data->Alamat = $request->Alamat;
        $data->Tanggal_Lahir = $request->Tanggal_Lahir;
        $data->Jenis_Kelamin = $request->Jenis_Kelamin;
        $data->Agama = $request->Agama;
        $data->NPWP = $request->NPWP;
        $data->Foto = $gambar;
        $post = $data->save();
        return response()->json([
            'status' => true,
            'message' => 'Data pegawai berhasil ditambahkan',
            'data' => $data
        ], 201);
    }


   public function update(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'NIP' => 'required',
        'Nama' => 'required',
        'Tempat_Lahir' => 'required',
        'Tanggal_Lahir' => 'required|date',
        'Alamat' => 'required',
        'Jenis_Kelamin' => 'required',
        'Agama' => 'required',
        'NPWP' => 'required',
        'Jabatan' => 'required',
        'Penugasan' => 'required',
        'Foto' => 'nullable|file|mimes:jpeg,png,jpg|max:2048', // Validate the image
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Validation failed',
            'errors' => $validator->errors(),
        ], 400);
    }

    // Find the existing Pegawai record
    $pegawai = Pegawai::findOrFail($id);

    // Update the Pegawai fields
    $pegawai->NIP = $request->input('NIP');
    $pegawai->Nama = $request->input('Nama');
    $pegawai->Tempat_Lahir = $request->input('Tempat_Lahir');
    $pegawai->Tanggal_Lahir = $request->input('Tanggal_Lahir');
    $pegawai->Alamat = $request->input('Alamat');
    $pegawai->Jenis_Kelamin = $request->input('Jenis_Kelamin');
    $pegawai->Agama = $request->input('Agama');
    $pegawai->NPWP = $request->input('NPWP');
    $pegawai->ID_Jabatan = $request->input('Jabatan');
    $pegawai->ID_Penugasan = $request->input('Penugasan');

    // Handle the Foto upload if a file is present
    if ($request->hasFile('Foto')) {
        $fotoPath = $request->file('Foto')->store('pegawai_fotos', 'public'); // Store in 'storage/app/public/pegawai_fotos'
        $pegawai->Foto = $fotoPath;
    }

    $pegawai->save();

    return response()->json([
        'status' => true,
        'data' => $pegawai,
    ]);
}

    public function destroy($id)
    {
        $data = Pegawai::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data pegawai tidak ditemukan'
            ], 404);
        }

        // Hapus foto jika ada
        if ($data->Foto && file_exists(storage_path('app/public/' . $data->Foto))) {
            unlink(storage_path('app/public/' . $data->Foto));
        }

        // Hapus data pegawai, yang juga akan menghapus data di tabel relasi
        $data->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data pegawai dan relasi berhasil dihapus'
        ], 200);
    }

}
