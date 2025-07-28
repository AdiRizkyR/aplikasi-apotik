<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\ObatMasuk;
use App\Models\DetailObatMasuk;
use App\Models\Obat;
use App\Models\DataObat;

class ObatController extends Controller
{
    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_terima' => 'required|date',
            'total_harga' => 'required|numeric',
            'detail' => 'required|array|min:1',
            'detail.*.obat_id' => 'required|exists:data_obats,id',
            'detail.*.jumlah_beli' => 'required|numeric|min:1',
            'detail.*.harga_beli' => 'required|numeric|min:0',
            'detail.*.harga_jual' => 'required|numeric|min:0',
            'detail.*.expired' => 'nullable|date',
        ]);

        DB::beginTransaction();
        try {
            $obatMasuk = ObatMasuk::findOrFail($id);
            $obatMasuk->update([
                'tanggal_terima' => $request->tanggal_terima,
                'total_harga' => $request->total_harga,
            ]);

            // Hapus detail lama
            DetailObatMasuk::where('obat_masuk_id', $id)->delete();

            foreach ($request->detail as $detail) {
                // Simpan detail_obat_masuks
                $detailMasuk = new DetailObatMasuk();
                $detailMasuk->obat_masuk_id = $obatMasuk->id;
                $detailMasuk->data_obat_id = $detail['obat_id'];
                $detailMasuk->jumlah_beli = $detail['jumlah_beli'];
                $detailMasuk->harga_beli = $detail['harga_beli'];
                $detailMasuk->harga_jual = $detail['harga_jual'];
                $detailMasuk->expired = $detail['expired'] ?? null;
                $detailMasuk->save();

                // Update stok di tabel obats jika sudah ada, atau buat baru
                Obat::updateOrCreate(
                    [
                        'data_obat_id' => $detail['obat_id'],
                        'obat_masuk_id' => $obatMasuk->id,
                        'expired' => $detail['expired'] ?? null,
                    ],
                    [
                        'stok' => $detail['jumlah_beli'], // jika ingin ditambah, ubah jadi: DB::raw('stok + ' . $detail['jumlah_beli'])
                        'harga' => $detail['harga_jual'],
                    ]
                );
            }

            DB::commit();
            return redirect()->back()->with('success', 'Data Obat Masuk berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function deleteDetail(Request $request, $id)
    {
        try {
            $detail = DetailObatMasuk::findOrFail($id);

            // Hapus stok dari tabel obats yang sesuai dengan data_obat_id, obat_masuk_id, dan expired
            Obat::where('data_obat_id', $request->obat_id)
                ->where('obat_masuk_id', $request->obat_masuk_id)
                ->whereDate('expired', $detail->expired)
                ->delete();

            // Hapus detail dari detail_obat_masuks
            $detail->delete();

            return response()->json([
                'success' => true,
                'message' => 'Detail obat berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus detail: ' . $e->getMessage()
            ]);
        }
    }
}