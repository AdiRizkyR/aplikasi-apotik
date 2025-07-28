<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\User;
use App\Models\Supplier;
use App\Models\Pelanggan;
use App\Models\DataObat;
use App\Models\Pemesanan;
use App\Models\ObatMasuk;
use App\Models\Obat;
use App\Models\Penjualan;

class viewController extends Controller
{
    // Begin::auth
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }
    // end::auth

    // begin::dashboard
    public function dashboard()
    {
        return view('layout.dashboard');
    }
    // end::dashboard

    // begin::user
    public function user()
    {
        $users = User::all(); // Mengambil semua data user
        return view('user.user', compact('users'));
    }
    // end::user

    // begin::pelanggan
    public function pelanggan()
    {
        $pelanggans = Pelanggan::latest()->get(); // Mengambil semua data, urutkan dari terbaru
        return view('pelanggan.pelanggan', compact('pelanggans'));
    }
    // end::pelanggan

    // begin::supplier
    public function supplier()
    {
        $suppliers = Supplier::latest()->get(); // ambil semua data supplier urut berdasarkan tanggal terbaru

        return view('supplier.supplier', compact('suppliers'));
    }
    // end::supplier

    // begin::data obat
    public function dataObat()
    {
        $dataObat = DataObat::latest()->get(); // Ambil semua data dari tabel data_obats
        return view('dataObat.dataObat', compact('dataObat'));
    }
    // end::data obat

    // begin::obat
    public function obat()
    {
        $now = Carbon::now();
        $limit = $now->copy()->addMonth(); // Batas expired 1 bulan ke depan

        $allObats = Obat::with('dataObat')->get();

        $groupedObats = [];

        foreach ($allObats as $obat) {
            // Hanya proses jika expired-nya masih lebih dari 1 bulan ke depan
            if ($obat->expired >= $limit) {
                $key = $obat->data_obat_id . '-' . $obat->harga;

                if (!isset($groupedObats[$key])) {
                    $groupedObats[$key] = [
                        'nama' => $obat->dataObat->nama,
                        'stok' => $obat->stok,
                        'harga' => $obat->harga,
                        'expired' => $obat->expired,
                        'id' => $obat->id, // bisa dipakai untuk aksi edit/hapus
                    ];
                } else {
                    $groupedObats[$key]['stok'] += $obat->stok;

                    if ($obat->expired < $groupedObats[$key]['expired']) {
                        $groupedObats[$key]['expired'] = $obat->expired;
                    }
                }
            }
        }

        return view('obat.obat', [
            'obats' => collect($groupedObats),
            'allObats' => $allObats,
        ]);
    }

    // end::obat

    // begin::penjualan
    public function penjualan()
    {
        $penjualans = Penjualan::with(['user', 'pelanggan', 'detailPenjualans.obat.dataObat'])->get();
        $pelanggans = Pelanggan::all();

        $now = Carbon::now();
        $limit = $now->copy()->addMonth(); // batas expired

        $allObats = Obat::with('dataObat')->get();
        $groupedObats = [];

        foreach ($allObats as $obat) {
            if ($obat->expired >= $limit) {
                $key = $obat->data_obat_id . '-' . $obat->harga;

                if (!isset($groupedObats[$key])) {
                    $groupedObats[$key] = [
                        'id' => $obat->id, // ambil satu ID saja dari grup
                        'nama' => $obat->dataObat->nama,
                        'stok' => $obat->stok,
                        'harga' => $obat->harga,
                        'expired' => $obat->expired,
                    ];
                } else {
                    $groupedObats[$key]['stok'] += $obat->stok;
                    if ($obat->expired < $groupedObats[$key]['expired']) {
                        $groupedObats[$key]['expired'] = $obat->expired;
                    }
                }
            }
        }

        $obats = collect($groupedObats);

        return view('penjualan.penjualan', compact('penjualans', 'pelanggans', 'obats'));
    }

    // end::penjualan

    // begin::pemesanan
    public function pemesanan()
    {
        $pemesanans = Pemesanan::with(['user', 'supplier', 'detailPemesanans', 'obatMasuks'])->get();
        $suppliers = Supplier::all(); // Ambil semua supplier
        $obats = DataObat::all();     // Ambil semua data obat

        return view('pemesanan.pemesanan', compact('pemesanans', 'suppliers', 'obats'));
    }
    // end::pemesanan

    // begin::obat masuk
    public function obatMasuk()
    {
        $obatMasuks = ObatMasuk::with([
            'pemesanan.user',
            'pemesanan.supplier',
            'detailObatMasuks.dataObat'
        ])->get();
        $obats = DataObat::all();

        return view('obatMasuk.obatMasuk', compact('obatMasuks', 'obats'));
    }
    // end::obat masuk

    // begin::report
        public function report()
        {
            return view('report.report');
        }

        // public function exportPDF(Request $request)
        // {
        //     $jenis = $request->jenis;
        //     $start = $request->start ?? now()->startOfMonth();
        //     $end = $request->end ?? now();
        //     $filterId = $request->filter_id;

        //     if (!$jenis || !$start || !$end) {
        //         return redirect()->back()->with('error', 'Semua input wajib diisi!');
        //     }

        //     $modelMap = [
        //         'users' => \App\Models\User::class,
        //         'suppliers' => \App\Models\Supplier::class,
        //         'pelanggans' => \App\Models\Pelanggan::class,
        //         'pemesanans' => \App\Models\Pemesanan::class,
        //         'obat_masuks' => \App\Models\ObatMasuk::class,
        //         'obats' => \App\Models\Obat::class,
        //         'penjualans' => \App\Models\Penjualan::class,
        //     ];

        //     if (!array_key_exists($jenis, $modelMap)) {
        //         return abort(404);
        //     }

        //     $model = $modelMap[$jenis];

        //     $query = $model::query();

        //     // filter berdasarkan tanggal
        //     $query->whereBetween('created_at', [$start, $end]);

        //     // filter berdasarkan relasi
        //     if ($filterId) {
        //         if (in_array($jenis, ['pemesanans', 'obat_masuks'])) {
        //             $query->where('supplier_id', $filterId)->orWhere('user_id', $filterId);
        //         } elseif ($jenis === 'penjualans') {
        //             $query->where('pelanggan_id', $filterId)->orWhere('user_id', $filterId);
        //         }
        //     }

        //     // eager load relasi jika perlu untuk PDF
        //     $with = [];

        //     if ($jenis === 'pemesanans') {
        //         $with = ['user', 'supplier'];
        //     } elseif ($jenis === 'obat_masuks') {
        //         $with = ['pemesanan.user', 'pemesanan.supplier'];
        //     } elseif ($jenis === 'penjualans') {
        //         $with = ['user', 'pelanggan'];
        //     }

        //     if (!empty($with)) {
        //         $query->with($with);
        //     }

        //     $data = $query->get();

        //     $pdf = Pdf::loadView('report.pdf', [
        //         'data' => $data,
        //         'start' => $start,
        //         'end' => $end,
        //         'jenis' => $jenis
        //     ])->setPaper('A4');

        //     return $pdf->stream('laporan_' . $jenis . '_' . now()->format('YmdHis') . '.pdf');
        // }

        // public function exportPDF(Request $request)
        // {
        //     $jenis = $request->jenis;
        //     $start = $request->start ?? now()->startOfMonth();
        //     $end = $request->end ?? now();
        //     $filterId = $request->filter_id;

        //     if (!$jenis || !$start || !$end) {
        //         return redirect()->back()->with('error', 'Semua input wajib diisi!');
        //     }

        //     $modelMap = [
        //         'users' => \App\Models\User::class,
        //         'suppliers' => \App\Models\Supplier::class,
        //         'pelanggans' => \App\Models\Pelanggan::class,
        //         'pemesanans' => \App\Models\Pemesanan::class,
        //         'obat_masuks' => \App\Models\ObatMasuk::class,
        //         'obats' => \App\Models\Obat::class,
        //         'penjualans' => \App\Models\Penjualan::class,
        //     ];

        //     if (!array_key_exists($jenis, $modelMap)) {
        //         return abort(404);
        //     }

        //     $model = $modelMap[$jenis];

        //     $query = $model::query();

        //     // Filter tanggal
        //     $query->whereBetween('created_at', [$start, $end]);

        //     // Filter relasi
        //     if ($filterId) {
        //         if (in_array($jenis, ['pemesanans', 'obat_masuks'])) {
        //             $query->where(function ($q) use ($filterId) {
        //                 $q->where('supplier_id', $filterId)
        //                 ->orWhere('user_id', $filterId);
        //             });
        //         } elseif ($jenis === 'penjualans') {
        //             $query->where(function ($q) use ($filterId) {
        //                 $q->where('pelanggan_id', $filterId)
        //                 ->orWhere('user_id', $filterId);
        //             });
        //         }
        //     }

        //     // Eager Load relasi
        //     $with = [];

        //     if ($jenis === 'pemesanans') {
        //         $with = ['user', 'supplier'];
        //     } elseif ($jenis === 'obat_masuks') {
        //         $with = ['pemesanan.user', 'pemesanan.supplier'];
        //     } elseif ($jenis === 'penjualans') {
        //         $with = ['user', 'pelanggan'];
        //     } elseif ($jenis === 'obats') {
        //         $with = ['dataObat'];
        //     }

        //     if (!empty($with)) {
        //         $query->with($with);
        //     }

        //     $data = $query->get();

        //     // Deteksi orientasi landscape jika kolom terlalu banyak (misalnya lebih dari 8 kolom)
        //     $attributes = $data->first()?->getAttributes() ?? [];
        //     $totalKolom = count(array_filter(array_keys($attributes), fn($col) => !in_array($col, ['created_at', 'updated_at', 'remember_token'])));

        //     $orientasi = $totalKolom > 8 ? 'landscape' : 'portrait';

        //     $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('report.pdf', [
        //         'data' => $data,
        //         'start' => $start,
        //         'end' => $end,
        //         'jenis' => $jenis
        //     ])->setPaper('a4', $orientasi);

        //     return $pdf->stream('laporan_' . $jenis . '_' . now()->format('YmdHis') . '.pdf');
        // }

        public function exportPDF(Request $request)
        {
            $jenis = $request->jenis;
            $start = $request->start ?? now()->startOfMonth();
            $end = $request->end ?? now();
            $filterId = $request->filter_id;

            $modelMap = [
                'users' => \App\Models\User::class,
                'suppliers' => \App\Models\Supplier::class,
                'pelanggans' => \App\Models\Pelanggan::class,
                'pemesanans' => \App\Models\Pemesanan::class,
                'obat_masuks' => \App\Models\ObatMasuk::class,
                'obats' => \App\Models\Obat::class,
                'penjualans' => \App\Models\Penjualan::class,
            ];

            if (!array_key_exists($jenis, $modelMap)) {
                return abort(404);
            }

            $model = $modelMap[$jenis];
            $query = $model::query()->whereBetween('created_at', [$start, $end]);

            // Tambahan relasi
            $with = [];

            if ($jenis === 'pemesanans') {
                $with = ['user', 'supplier', 'detailPemesanans.dataObat'];
                if ($filterId) {
                    $query->where('user_id', $filterId)->orWhere('supplier_id', $filterId);
                }
            } elseif ($jenis === 'obat_masuks') {
                $with = ['pemesanan.user', 'pemesanan.supplier', 'detailObatMasuks.dataObat'];
                if ($filterId) {
                    $query->whereHas('pemesanan', function ($q) use ($filterId) {
                        $q->where('user_id', $filterId)->orWhere('supplier_id', $filterId);
                    });
                }
            } elseif ($jenis === 'penjualans') {
                $with = ['user', 'pelanggan', 'detailPenjualans.obat.dataObat'];
                if ($filterId) {
                    $query->where('user_id', $filterId)->orWhere('pelanggan_id', $filterId);
                }
            }

            if (!empty($with)) {
                $query->with($with);
            }

            $data = $query->get();

            // Landscape jika tabel kompleks
            $isLandscape = in_array($jenis, ['pemesanans', 'obat_masuks', 'penjualans']);
            $orientation = $isLandscape ? 'landscape' : 'portrait';

            $pdf = Pdf::loadView('report.pdf', [
                'data' => $data,
                'start' => $start,
                'end' => $end,
                'jenis' => $jenis,
            ])->setPaper('A4', $orientation);

            return $pdf->stream('laporan_' . $jenis . '_' . now()->format('YmdHis') . '.pdf');
        }

        public function reportUser()
        {
            return view('report.user.reportUser');
        }

        public function reportSupplier()
        {
            return view('report.supplier.reportSupplier');
        }

        public function reportPelanggan()
        {
            return view('report.pelanggan.reportPelanggan');
        }

        public function reportPemesanan()
        {
            return view('report.pemesanan.reportPemesanan');
        }

        public function reportObatMasuk()
        {
            return view('report.obatMasuk.reportObatMasuk');
        }

        public function reportPenjualan()
        {
            return view('report.penjualan.reportPenjualan');
        }

        public function reportObat()
        {
            return view('report.obat.reportObat');
        }
    // end::report
}