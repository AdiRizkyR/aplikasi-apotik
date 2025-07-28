<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Pemesanan;
use App\Models\DetailPemesanan;
use App\Models\ObatMasuk;
use App\Models\DetailObatMasuk;

class PemesananController extends Controller
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
            'user_id' => 'required|exists:users,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'tanggal_pesan' => 'required|date',
            'total' => 'required|numeric|min:0',
            'detail_obats' => 'required|array|min:1',
            'detail_obats.*.obat_id' => 'required|exists:data_obats,id',
            'detail_obats.*.jumlah_beli' => 'required|integer|min:1',
            'detail_obats.*.harga_beli' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            // 1. Simpan ke pemesanans
            $pemesanan = Pemesanan::create([
                'user_id' => $request->user_id,
                'supplier_id' => $request->supplier_id,
                'tanggal_pesan' => $request->tanggal_pesan,
                'total' => $request->total,
            ]);

            // 2. Simpan ke detail_pemesanans
            foreach ($request->detail_obats as $item) {
                DetailPemesanan::create([
                    'pemesanan_id' => $pemesanan->id,
                    'data_obat_id' => $item['obat_id'],
                    'jumlah_beli' => $item['jumlah_beli'],
                    'harga_beli' => $item['harga_beli'],
                ]);
            }

            // 3. Simpan ke obat_masuks
            $obatMasuk = ObatMasuk::create([
                'pemesanan_id' => $pemesanan->id,
                'tanggal_terima' => null,
                'total_harga' => $pemesanan->total,
            ]);

            // 4. Simpan ke detail_obat_masuks
            foreach ($request->detail_obats as $item) {
                DetailObatMasuk::create([
                    'obat_masuk_id' => $obatMasuk->id,
                    'data_obat_id' => $item['obat_id'],
                    'jumlah_beli' => $item['jumlah_beli'],
                    'harga_beli' => $item['harga_beli'],
                    'harga_jual' => null,
                    'expired' => null,
                ]);
            }

            DB::commit();

            return redirect()->route('pemesanan')->with('success', 'Data pemesanan berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data.')->withErrors(['msg' => $e->getMessage()]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $pemesanan = Pemesanan::findOrFail($id);

            // Hapus detail pemesanan
            $pemesanan->detailPemesanans()->delete();

            // Cari dan hapus obat masuk yang terkait
            $obatMasuk = ObatMasuk::where('pemesanan_id', $pemesanan->id)->first();

            if ($obatMasuk) {
                $obatMasuk->detailObatMasuks()->delete();
                $obatMasuk->delete();
            }

            // Hapus data utama pemesanan
            $pemesanan->delete();

            DB::commit();
            return back()->with('success', 'Data pemesanan berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menghapus data.')->withErrors(['msg' => $e->getMessage()]);
        }
    }
}
