<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\DataObat;

class DataObatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'data' => 'required|array|min:1',
            'data.*.nama' => 'required|string|max:255',
            'data.*.jenis' => 'required|string|max:255',
            'data.*.kategori' => 'required|string|max:255',
        ]);

        try {
            foreach ($request->data as $obat) {
                DataObat::create([
                    'nama' => $obat['nama'],
                    'jenis' => $obat['jenis'],
                    'kategori' => $obat['kategori'],
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data obat berhasil disimpan!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
        ]);

        try {
            $obat = DataObat::findOrFail($id);
            $obat->update([
                'nama' => $request->nama,
                'jenis' => $request->jenis,
                'kategori' => $request->kategori,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data obat berhasil diperbarui!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $obat = DataObat::findOrFail($id);
            $obat->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data obat berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }
}
