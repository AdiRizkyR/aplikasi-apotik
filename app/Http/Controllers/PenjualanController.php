<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Obat;

class PenjualanController extends Controller
{
    public function cetak($id)
    {
        $penjualan = \App\Models\Penjualan::with([
            'user',
            'pelanggan',
            'detailPenjualans.obat.dataObat'
        ])->findOrFail($id);

        $jenis = 'penjualan';

        // Karena pdf.blade.php dirancang untuk koleksi $data, bungkus jadi array
        $data = collect([$penjualan]);

        $pdf = Pdf::loadView('penjualan.pdf', compact('data', 'jenis'))->setPaper('a4');

        return $pdf->stream("penjualan_{$penjualan->id}.pdf");
    }

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
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'tanggal_pesan' => 'required|date',
            'tanggal_terima' => 'required|date',
            'total' => 'required|numeric|min:0',
            'detail' => 'required|array|min:1',
            'detail.*.obat_id' => 'required|exists:obats,id',
            'detail.*.jumlah' => 'required|numeric|min:1',
            'detail.*.harga' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Simpan data utama penjualan
            $penjualan = Penjualan::create([
                'user_id' => $request->user_id,
                'pelanggan_id' => $request->pelanggan_id,
                'tanggal_pesan' => $request->tanggal_pesan,
                'tanggal_terima' => $request->tanggal_terima,
                'total' => $request->total,
            ]);

            foreach ($request->detail as $item) {
                $obat = Obat::findOrFail($item['obat_id']);

                // Validasi stok
                if ($obat->stok < $item['jumlah']) {
                    throw new \Exception("Stok obat '{$obat->nama}' tidak mencukupi.");
                }

                // Simpan detail penjualan
                DetailPenjualan::create([
                    'penjualan_id' => $penjualan->id,
                    'obat_id' => $item['obat_id'],
                    'jumlah_beli' => $item['jumlah'],
                    'harga' => $item['harga'],
                    'subtotal' => $item['jumlah'] * $item['harga'],
                ]);

                // Kurangi stok obat
                $obat->stok -= $item['jumlah'];
                $obat->save();
            }

            DB::commit();

            return redirect()->route('penjualan')->with([
                'success' => 'Penjualan berhasil disimpan!',
                'open_pdf_id' => $penjualan->id
            ]);

            // return redirect()->route('penjualan')->with('success', 'Penjualan berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan penjualan: ' . $e->getMessage());
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
