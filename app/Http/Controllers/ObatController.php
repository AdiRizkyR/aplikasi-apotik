<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\ObatMasuk;
use App\Models\DetailObatMasuk;
use App\Models\Obat;
use App\Models\DataObat;
use App\Models\DetailPenjualan;

class ObatController extends Controller
{
    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'tanggal_terima' => 'required|date',
    //         'total_harga' => 'required|numeric',
    //         'detail' => 'required|array|min:1',
    //         'detail.*.obat_id' => 'required|exists:data_obats,id',
    //         'detail.*.jumlah_beli' => 'required|numeric|min:1',
    //         'detail.*.harga_beli' => 'required|numeric|min:0',
    //         'detail.*.harga_jual' => 'required|numeric|min:0',
    //         'detail.*.expired' => 'nullable|date',
    //     ]);

    //     DB::beginTransaction();
    //     try {
    //         $obatMasuk = ObatMasuk::findOrFail($id);
    //         $obatMasuk->update([
    //             'tanggal_terima' => $request->tanggal_terima,
    //             'total_harga' => $request->total_harga,
    //         ]);

    //         // Hapus detail lama
    //         DetailObatMasuk::where('obat_masuk_id', $id)->delete();

    //         foreach ($request->detail as $detail) {
    //             // Simpan detail_obat_masuks
    //             $detailMasuk = new DetailObatMasuk();
    //             $detailMasuk->obat_masuk_id = $obatMasuk->id;
    //             $detailMasuk->data_obat_id = $detail['obat_id'];
    //             $detailMasuk->jumlah_beli = $detail['jumlah_beli'];
    //             $detailMasuk->harga_beli = $detail['harga_beli'];
    //             $detailMasuk->harga_jual = $detail['harga_jual'];
    //             $detailMasuk->expired = $detail['expired'] ?? null;
    //             $detailMasuk->save();

    //             // Update stok di tabel obats jika sudah ada, atau buat baru
    //             Obat::updateOrCreate(
    //                 [
    //                     'data_obat_id' => $detail['obat_id'],
    //                     'obat_masuk_id' => $obatMasuk->id,
    //                     'expired' => $detail['expired'] ?? null,
    //                 ],
    //                 [
    //                     'stok' => $detail['jumlah_beli'], // jika ingin ditambah, ubah jadi: DB::raw('stok + ' . $detail['jumlah_beli'])
    //                     'harga' => $detail['harga_jual'],
    //                 ]
    //             );
    //         }

    //         DB::commit();
    //         return redirect()->back()->with('success', 'Data Obat Masuk berhasil diperbarui.');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    //     }
    // }

    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'tanggal_terima' => 'required|date',
    //         'total_harga' => 'required|numeric',
    //         'detail' => 'required|array|min:1',
    //         'detail.*.obat_id' => 'required|exists:data_obats,id',
    //         'detail.*.no_batch' => 'required|string|max:255',
    //         'detail.*.jumlah_beli' => 'required|numeric|min:1',
    //         'detail.*.harga_beli' => 'required|numeric|min:0',
    //         'detail.*.harga_jual' => 'required|numeric|min:0',
    //         'detail.*.expired' => 'nullable|date',
    //     ]);

    //     DB::beginTransaction();
    //     try {
    //         // Update data utama di tabel obat_masuks
    //         $obatMasuk = ObatMasuk::findOrFail($id);
    //         $obatMasuk->update([
    //             'tanggal_terima' => $request->tanggal_terima,
    //             'total_harga' => $request->total_harga,
    //         ]);

    //         // Hapus detail lama terkait obat masuk ini
    //         DetailObatMasuk::where('obat_masuk_id', $id)->delete();

    //         // Hapus stok lama dari tabel obats juga
    //         Obat::where('obat_masuk_id', $id)->delete();

    //         // Simpan ulang data detail dan stok baru
    //         foreach ($request->detail as $detail) {
    //             // Simpan ke detail_obat_masuks
    //             $detailMasuk = new DetailObatMasuk();
    //             $detailMasuk->obat_masuk_id = $obatMasuk->id;
    //             $detailMasuk->data_obat_id = $detail['obat_id'];
    //             $detailMasuk->no_batch = $detail['no_batch'];
    //             $detailMasuk->jumlah_beli = $detail['jumlah_beli'];
    //             $detailMasuk->harga_beli = $detail['harga_beli'];
    //             $detailMasuk->harga_jual = $detail['harga_jual'];
    //             $detailMasuk->expired = $detail['expired'] ?? null;
    //             $detailMasuk->save();

    //             // Simpan ke tabel obats (stok)
    //             Obat::create([
    //                 'data_obat_id' => $detail['obat_id'],
    //                 'obat_masuk_id' => $obatMasuk->id,
    //                 'no_batch' => $detail['no_batch'],
    //                 'stok' => $detail['jumlah_beli'],
    //                 'harga' => $detail['harga_jual'],
    //                 'expired' => $detail['expired'] ?? null,
    //             ]);
    //         }

    //         DB::commit();
    //         return redirect()->back()->with('success', 'Data Obat Masuk berhasil diperbarui.');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    //     }
    // }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_terima' => 'required|date',
            'total_harga' => 'required|numeric',
            'detail' => 'required|array|min:1',
            'detail.*.obat_id' => 'required|exists:data_obats,id',
            'detail.*.no_batch' => 'required|string|max:255',
            'detail.*.jumlah_beli' => 'required|numeric|min:1',
            'detail.*.harga_beli' => 'required|numeric|min:0',
            'detail.*.harga_jual' => 'required|numeric|min:0',
            'detail.*.expired' => 'nullable|date',
        ]);

        DB::beginTransaction();
        try {
            // Update data utama di tabel obat_masuks
            $obatMasuk = ObatMasuk::findOrFail($id);
            $obatMasuk->update([
                'tanggal_terima' => $request->tanggal_terima,
                'total_harga' => $request->total_harga,
            ]);

            // Hapus detail lama
            DetailObatMasuk::where('obat_masuk_id', $id)->delete();

            // Proses detail baru
            foreach ($request->detail as $detail) {
                // Simpan ke detail_obat_masuks
                $detailMasuk = new DetailObatMasuk();
                $detailMasuk->obat_masuk_id = $obatMasuk->id;
                $detailMasuk->data_obat_id = $detail['obat_id'];
                $detailMasuk->no_batch = $detail['no_batch'];
                $detailMasuk->jumlah_beli = $detail['jumlah_beli'];
                $detailMasuk->harga_beli = $detail['harga_beli'];
                $detailMasuk->harga_jual = $detail['harga_jual'];
                $detailMasuk->expired = $detail['expired'] ?? null;
                $detailMasuk->save();

                // Cari stok lama berdasarkan obat_masuk_id dan no_batch
                $obat = Obat::where('obat_masuk_id', $id)
                            ->where('no_batch', $detail['no_batch'])
                            ->where('data_obat_id', $detail['obat_id'])
                            ->first();
                if ($obat) {
                    $jumlahTerjual = DetailPenjualan::with('obat')
                        ->whereHas('obat', function ($query) use ($detail, $id) {
                            $query->where('obat_masuk_id', $id);
                            // ->where('no_batch', $detail['no_batch']);
                        })
                        ->sum('jumlah_beli');
                    // Hitung jumlah obat yang sudah terjual
                    // $jumlahTerjual = \DB::table('detail_penjualans')
                    //     ->join('obats', 'obats.data_obat_id', '=', 'detail_penjualans.obat_id');
                    //     ->where('obats.no_batch', $detail['no_batch'])
                    //     ->where('obats.obat_masuk_id', $id)
                    //     ->where('detail_penjualans.obat_id', $detail['obat_id']);
                    // dd($jumlahTerjual);

                    // Pastikan jumlah beli baru tidak lebih kecil dari yang sudah terjual
                    if ($detail['jumlah_beli'] < $jumlahTerjual) {
                        throw new \Exception("Jumlah beli untuk no batch {$detail['no_batch']} tidak boleh kurang dari jumlah yang sudah terjual ($jumlahTerjual).");
                    }

                    // Update stok (jumlah_beli - jumlah terjual)
                    $obat->update([
                        'stok' => $detail['jumlah_beli'] - $jumlahTerjual,
                        'harga' => $detail['harga_jual'],
                        'expired' => $detail['expired'] ?? null,
                    ]);
                } else {
                    // Jika belum pernah ada stok, maka buat baru
                    Obat::create([
                        'data_obat_id' => $detail['obat_id'],
                        'obat_masuk_id' => $obatMasuk->id,
                        'no_batch' => $detail['no_batch'],
                        'stok' => $detail['jumlah_beli'],
                        'harga' => $detail['harga_jual'],
                        'expired' => $detail['expired'] ?? null,
                    ]);
                }
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