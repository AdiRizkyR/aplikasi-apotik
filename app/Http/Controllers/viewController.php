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
        return view('layout.dashboard', [
            'userCount'       => User::count(),
            'supplierCount'   => Supplier::count(),
            'pelangganCount'  => Pelanggan::count(),
            'obatCount'       => DataObat::count(),
            'stokTotal'       => Obat::sum('stok'),
            'penjualanCount'  => Penjualan::count(),
            'pemesananCount'  => Pemesanan::count(),
        ]);
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
    // public function obat()
    // {
    //     $now = Carbon::now();
    //     $limit = $now->copy()->addMonth(); // Batas expired 1 bulan ke depan

    //     $allObats = Obat::with('dataObat')->get();

    //     $groupedObats = [];

    //     foreach ($allObats as $obat) {
    //         // Hanya proses jika expired-nya masih lebih dari 1 bulan ke depan
    //         if ($obat->expired >= $limit) {
    //             $key = $obat->data_obat_id . '-' . $obat->harga;

    //             if (!isset($groupedObats[$key])) {
    //                 $groupedObats[$key] = [
    //                     'nama' => $obat->dataObat->nama,
    //                     'no_batch' => $obat->no_batch,
    //                     'stok' => $obat->stok,
    //                     'harga' => $obat->harga,
    //                     'expired' => $obat->expired,
    //                     'id' => $obat->id, // bisa dipakai untuk aksi edit/hapus
    //                 ];
    //             } else {
    //                 $groupedObats[$key]['stok'] += $obat->stok;

    //                 if ($obat->expired < $groupedObats[$key]['expired']) {
    //                     $groupedObats[$key]['expired'] = $obat->expired;
    //                 }
    //             }
    //         }
    //     }

    //     return view('obat.obat', [
    //         'obats' => collect($groupedObats),
    //         'allObats' => $allObats,
    //     ]);
    // }

    public function obat()
    {
        $now = Carbon::now();
        $limit = $now->copy()->addMonth(); // Batas expired 1 bulan ke depan

        $allObats = Obat::with('dataObat')->get();
        $groupedObats = [];

        foreach ($allObats as $obat) {
            // $key = $obat->data_obat_id . '-' . $obat->harga;
            $key = $obat->data_obat_id;

            // Tentukan status expired (misal: "aman", "hampir expired", atau "expired")
            $statusExpired = 'aman';
            if ($obat->expired < $now) {
                $statusExpired = 'expired';
            } elseif ($obat->expired <= $limit) {
                $statusExpired = 'hampir expired';
            }

            if (!isset($groupedObats[$key])) {
                $groupedObats[$key] = [
                    'nama' => $obat->dataObat->nama,
                    'no_batch' => $obat->no_batch,
                    'stok' => $obat->stok,
                    'harga' => $obat->harga,
                    'expired' => $obat->expired,
                    'id' => $obat->id,
                    'status_expired' => $statusExpired, // penanda status
                ];
            } else {
                $groupedObats[$key]['stok'] += $obat->stok;

                // Ambil expired terdekat
                if ($obat->expired < $groupedObats[$key]['expired']) {
                    $groupedObats[$key]['expired'] = $obat->expired;
                    $groupedObats[$key]['status_expired'] = $statusExpired; // update status expired juga
                }
            }
        }
        return view('obat.obat', [
            'obats' => collect($groupedObats)->sortBy('nama'), // Urutkan berdasarkan nama
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
        // $obats = collect($groupedObats)->sortBy('nama')->values();

        return view('penjualan.penjualan', compact('penjualans', 'pelanggans', 'obats'));
    }

    // end::penjualan

    // begin::pemesanan
    public function pemesanan()
    {
        $pemesanans = Pemesanan::with(['user', 'supplier', 'detailPemesanans', 'obatMasuks'])->get();
        $suppliers = Supplier::all(); // Ambil semua supplier
        // $obats = DataObat::all();
        $obats = DataObat::orderBy('nama', 'asc')->get();

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
        // public function report()
        // {
        //     return view('report.report');
        // }

        // public function exportPDF(Request $request)
        // {
        //     $jenis = $request->jenis;
        //     $start = $request->start ?? now()->startOfMonth();
        //     $end = $request->end ?? now();
        //     $filterId = $request->filter_id;

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
        //     $query = $model::query()->whereBetween('created_at', [$start, $end]);

        //     // Tambahan relasi
        //     $with = [];

        //     if ($jenis === 'pemesanans') {
        //         $with = ['user', 'supplier', 'detailPemesanans.dataObat'];
        //         if ($filterId) {
        //             $query->where('user_id', $filterId)->orWhere('supplier_id', $filterId);
        //         }
        //     } elseif ($jenis === 'obat_masuks') {
        //         $with = ['pemesanan.user', 'pemesanan.supplier', 'detailObatMasuks.dataObat'];
        //         if ($filterId) {
        //             $query->whereHas('pemesanan', function ($q) use ($filterId) {
        //                 $q->where('user_id', $filterId)->orWhere('supplier_id', $filterId);
        //             });
        //         }
        //     } elseif ($jenis === 'penjualans') {
        //         $with = ['user', 'pelanggan', 'detailPenjualans.obat.dataObat'];
        //         if ($filterId) {
        //             $query->where('user_id', $filterId)->orWhere('pelanggan_id', $filterId);
        //         }
        //     }

        //     if (!empty($with)) {
        //         $query->with($with);
        //     }

        //     $data = $query->get();

        //     // Landscape jika tabel kompleks
        //     $isLandscape = in_array($jenis, ['pemesanans', 'obat_masuks', 'penjualans']);
        //     $orientation = $isLandscape ? 'landscape' : 'portrait';

        //     $pdf = Pdf::loadView('report.pdf', [
        //         'data' => $data,
        //         'start' => $start,
        //         'end' => $end,
        //         'jenis' => $jenis,
        //     ])->setPaper('A4', $orientation);

        //     return $pdf->stream('laporan_' . $jenis . '_' . now()->format('YmdHis') . '.pdf');
        // }

        // report user
            public function reportUser()
            {
                return view('report.user.reportUser');
            }

            public function printReportUser(Request $request)
            {
                $request->validate([
                    'jenis' => 'required|in:users,suppliers,pelanggans'
                ]);

                $jenis = $request->jenis;
                $start = now()->startOfYear(); // bisa disesuaikan
                $end = now();

                switch ($jenis) {
                    case 'users':
                        $data = User::all();
                        break;
                    case 'suppliers':
                        $data = Supplier::all();
                        break;
                    case 'pelanggans':
                        $data = Pelanggan::all();
                        break;
                    default:
                        abort(404);
                }

                $pdf = Pdf::loadView('report.user.pdf', compact('data', 'jenis', 'start', 'end'))->setPaper('a4');
                return $pdf->stream("laporan_{$jenis}_" . now()->format('Ymd_His') . ".pdf");
            }
        // end report user

        // report pemesanan
            public function reportPemesanan()
            {
                return view('report.pemesanan.reportPemesanan');
            }

            // public function reportPemesananPrint(Request $request)
            // {
            //     $query = Pemesanan::with(['user', 'supplier', 'detailPemesanans.dataObat']);

            //     // Filter berdasarkan jenis
            //     if ($request->filter !== 'all') {
            //         if ($request->filter == 'user') {
            //             $query->where('user_id', $request->filter_value);
            //         } elseif ($request->filter == 'supplier') {
            //             $query->where('supplier_id', $request->filter_value);
            //         } elseif ($request->filter == 'obat') {
            //             $query->whereHas('detailPemesanans', function ($q) use ($request) {
            //                 $q->where('data_obat_id', $request->filter_value);
            //             });
            //         }
            //     }

            //     // Filter waktu
            //     $start = $end = now();
            //     if ($request->waktu == 'tanggal') {
            //         $start = $end = $request->tanggal;
            //         $query->whereDate('tanggal_pesan', $request->tanggal);
            //     } elseif ($request->waktu == 'bulan') {
            //         [$year, $month] = explode('-', $request->bulan);
            //         $query->whereYear('tanggal_pesan', $year)->whereMonth('tanggal_pesan', $month);
            //         $start = Carbon::create($year, $month)->startOfMonth();
            //         $end = Carbon::create($year, $month)->endOfMonth();
            //     } elseif ($request->waktu == 'tahun') {
            //         $query->whereYear('tanggal_pesan', $request->tahun);
            //         $start = Carbon::create($request->tahun)->startOfYear();
            //         $end = Carbon::create($request->tahun)->endOfYear();
            //     }

            //     $data = $query->get();

            //     $pdf = Pdf::loadView('report.pemesanan.pdf', [
            //         'data' => $data,
            //         'jenis' => 'pemesanans',
            //         'start' => $start,
            //         'end' => $end
            //     ])->setPaper('a4', 'landscape'); // atur ukuran dan orientasi landscape

            //     return $pdf->stream('laporan_pemesanan.pdf');
            // }

            public function reportPemesananPrint(Request $request)
            {
                $query = Pemesanan::with(['user', 'supplier', 'detailPemesanans.dataObat']);

                // Filter berdasarkan jenis (opsional, kalau kamu pakai filter user/supplier/obat)
                if ($request->filter !== 'all') {
                    if ($request->filter == 'user') {
                        $query->where('user_id', $request->filter_value);
                    } elseif ($request->filter == 'supplier') {
                        $query->where('supplier_id', $request->filter_value);
                    } elseif ($request->filter == 'obat') {
                        $query->whereHas('detailPemesanans', function ($q) use ($request) {
                            $q->where('data_obat_id', $request->filter_value);
                        });
                    }
                }

                // Filter waktu
                $start = $end = now(); // default

                if ($request->waktu == 'tanggal') {
                    $start = $end = $request->tanggal;
                    $query->whereDate('tanggal_pesan', $request->tanggal);
                } elseif ($request->waktu == 'bulan') {
                    [$year, $month] = explode('-', $request->bulan);
                    $start = Carbon::create($year, $month)->startOfMonth();
                    $end = Carbon::create($year, $month)->endOfMonth();
                    $query->whereYear('tanggal_pesan', $year)->whereMonth('tanggal_pesan', $month);
                } elseif ($request->waktu == 'tahun') {
                    $start = Carbon::create($request->tahun)->startOfYear();
                    $end = Carbon::create($request->tahun)->endOfYear();
                    $query->whereYear('tanggal_pesan', $request->tahun);
                } elseif ($request->waktu == 'periode') {
                    $start = $request->tanggal_awal;
                    $end = $request->tanggal_akhir;
                    $query->whereBetween('tanggal_pesan', [$start, $end]);
                }

                $data = $query->get();

                $pdf = Pdf::loadView('report.pemesanan.pdf', [
                    'data' => $data,
                    'jenis' => 'pemesanans',
                    'start' => $start,
                    'end' => $end
                ])->setPaper('a4', 'landscape');

                return $pdf->stream('laporan_pemesanan.pdf');
            }
        // end report pemesanan

        // obat masuk
            public function reportObatMasuk()
            {
                return view('report.obatMasuk.reportObatMasuk');
            }

            // public function reportObatMasukPrint(Request $request)
            // {
            //     $query = ObatMasuk::with([
            //         'pemesanan.user',
            //         'pemesanan.supplier',
            //         'detailObatMasuks.dataObat'
            //     ]);

            //     $start = $end = now();

            //     if ($request->waktu === 'tanggal') {
            //         $start = $end = $request->tanggal;
            //         $query->whereDate('tanggal_terima', $request->tanggal);
            //     } elseif ($request->waktu === 'bulan') {
            //         [$year, $month] = explode('-', $request->bulan);
            //         $query->whereYear('tanggal_terima', $year)->whereMonth('tanggal_terima', $month);
            //         $start = Carbon::create($year, $month)->startOfMonth();
            //         $end = Carbon::create($year, $month)->endOfMonth();
            //     } elseif ($request->waktu === 'tahun') {
            //         $query->whereYear('tanggal_terima', $request->tahun);
            //         $start = Carbon::create($request->tahun)->startOfYear();
            //         $end = Carbon::create($request->tahun)->endOfYear();
            //     }

            //     $data = $query->get();

            //     $pdf = Pdf::loadView('report.obatMasuk.pdf', [
            //         'data' => $data,
            //         'jenis' => $request->jenis,
            //         'start' => $start,
            //         'end' => $end,
            //         'waktu' => $request->waktu // WAJIB agar Blade bisa bedakan jenis tampilan
            //     ])->setPaper('a4', 'landscape');

            //     return $pdf->stream('laporan_obat_masuk.pdf');
            // }

            public function reportObatMasukPrint(Request $request)
            {
                $query = ObatMasuk::with([
                    'pemesanan.user',
                    'pemesanan.supplier',
                    'detailObatMasuks.dataObat'
                ]);

                $start = $end = now();

                if ($request->waktu === 'tanggal') {
                    $start = $end = $request->tanggal;
                    $query->whereDate('tanggal_terima', $request->tanggal);
                } elseif ($request->waktu === 'bulan') {
                    [$year, $month] = explode('-', $request->bulan);
                    $query->whereYear('tanggal_terima', $year)->whereMonth('tanggal_terima', $month);
                    $start = Carbon::create($year, $month)->startOfMonth();
                    $end = Carbon::create($year, $month)->endOfMonth();
                } elseif ($request->waktu === 'tahun') {
                    $query->whereYear('tanggal_terima', $request->tahun);
                    $start = Carbon::create($request->tahun)->startOfYear();
                    $end = Carbon::create($request->tahun)->endOfYear();
                } elseif ($request->waktu === 'periode') {
                    $start = $request->tanggal_awal;
                    $end = $request->tanggal_akhir;
                    $query->whereBetween('tanggal_terima', [$start, $end]);
                }

                $data = $query->get();

                $pdf = Pdf::loadView('report.obatMasuk.pdf', [
                    'data' => $data,
                    'jenis' => $request->jenis,
                    'start' => $start,
                    'end' => $end,
                    'waktu' => $request->waktu
                ])->setPaper('a4', 'landscape');

                return $pdf->stream('laporan_obat_masuk.pdf');
            }
        // end obat masuk

        // penjualan
        public function reportPenjualan()
        {
            return view('report.penjualan.reportPenjualan');
        }

        // public function reportPenjualanPrint(Request $request)
        // {
        //     $query = Penjualan::with(['user', 'pelanggan', 'detailPenjualans.obat.dataObat']);

        //     $start = $end = now();

        //     if ($request->waktu == 'tanggal') {
        //         $start = $end = $request->tanggal;
        //         $query->whereDate('tanggal_pesan', $request->tanggal);
        //     } elseif ($request->waktu == 'bulan') {
        //         [$year, $month] = explode('-', $request->bulan);
        //         $query->whereYear('tanggal_pesan', $year)->whereMonth('tanggal_pesan', $month);
        //         $start = Carbon::create($year, $month)->startOfMonth();
        //         $end = Carbon::create($year, $month)->endOfMonth();
        //     } elseif ($request->waktu == 'tahun') {
        //         $query->whereYear('tanggal_pesan', $request->tahun);
        //         $start = Carbon::create($request->tahun)->startOfYear();
        //         $end = Carbon::create($request->tahun)->endOfYear();
        //     }

        //     $data = $query->get();

        //     $pdf = Pdf::loadView('report.penjualan.pdf', [
        //         'data' => $data,
        //         'jenis' => $request->jenis,
        //         'start' => $start,
        //         'end' => $end
        //     ])->setPaper('a4', 'landscape');

        //     return $pdf->stream('laporan_penjualan.pdf');
        // }

        public function reportPenjualanPrint(Request $request)
        {
            $query = Penjualan::with(['user', 'pelanggan', 'detailPenjualans.obat.dataObat']);

            $start = $end = now(); // default

            if ($request->waktu == 'tanggal') {
                $start = $end = $request->tanggal;
                $query->whereDate('tanggal_pesan', $request->tanggal);
            } elseif ($request->waktu == 'bulan') {
                [$year, $month] = explode('-', $request->bulan);
                $query->whereYear('tanggal_pesan', $year)->whereMonth('tanggal_pesan', $month);
                $start = Carbon::create($year, $month)->startOfMonth();
                $end = Carbon::create($year, $month)->endOfMonth();
            } elseif ($request->waktu == 'tahun') {
                $query->whereYear('tanggal_pesan', $request->tahun);
                $start = Carbon::create($request->tahun)->startOfYear();
                $end = Carbon::create($request->tahun)->endOfYear();
            } elseif ($request->waktu == 'periode') {
                // Validasi input tanggal_awal dan tanggal_akhir
                $request->validate([
                    'tanggal_awal' => 'required|date',
                    'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
                ]);

                $start = Carbon::parse($request->tanggal_awal)->startOfDay();
                $end = Carbon::parse($request->tanggal_akhir)->endOfDay();

                $query->whereBetween('tanggal_pesan', [$start, $end]);
            }

            $data = $query->get();

            $pdf = Pdf::loadView('report.penjualan.pdf', [
                'data' => $data,
                'jenis' => $request->jenis,
                'start' => $start,
                'end' => $end
            ])->setPaper('a4', 'landscape');

            return $pdf->stream('laporan_penjualan.pdf');
        }
        // end penjualan

        // obat
        public function reportObat()
        {
            return view('report.obat.reportObat');
        }

        // public function printReportObat(Request $request)
        // {
        //     $request->validate([
        //         'jenis' => 'required|in:expired,stok,laporan',
        //     ]);

        //     $jenis = $request->jenis;
        //     $today = now();

        //     switch ($jenis) {
        //         case 'expired':
        //             $data = Obat::with('dataObat')
        //                 ->whereDate('expired', '<', $today)
        //                 ->get();
        //             break;

        //         case 'stok':
        //             $data = Obat::with('dataObat')
        //                 ->where(function ($query) use ($today) {
        //                     $query->whereNull('expired')
        //                         ->orWhereDate('expired', '>=', $today->addMonth());
        //                 })
        //                 ->get()
        //                 ->groupBy(fn($item) => $item->dataObat->nama . '-' . $item->harga)
        //                 ->map(function ($group) {
        //                     return [
        //                         'nama' => $group->first()->dataObat->nama,
        //                         'kategori' => $group->first()->dataObat->kategori ?? '-',
        //                         'jenis' => $group->first()->dataObat->jenis ?? '-',
        //                         'no_batch' => $group->first()->no_batch,
        //                         'harga' => $group->first()->harga,
        //                         'stok' => $group->sum('stok'),
        //                     ];
        //                 })->values();
        //             break;

        //         case 'laporan':
        //             $data = Obat::with('dataObat')
        //                 ->where(function ($query) use ($today) {
        //                     $query->whereNull('expired')
        //                         ->orWhereDate('expired', '>=', $today);
        //                 })
        //                 ->get()
        //                 ->groupBy(fn($item) => $item->dataObat->nama . '-' . $item->harga)
        //                 ->map(function ($group) {
        //                     return [
        //                         'nama' => $group->first()->dataObat->nama,
        //                         'kategori' => $group->first()->dataObat->kategori ?? '-',
        //                         'jenis' => $group->first()->dataObat->jenis ?? '-',
        //                         'no_batch' => $group->first()->no_batch,
        //                         'harga' => $group->first()->harga,
        //                         'stok' => $group->sum('stok'),
        //                         'expired_terdekat' => $group->min('expired'),
        //                     ];
        //                 })->values();
        //             break;

        //         default:
        //             abort(404);
        //     }

        //     $pdf = Pdf::loadView('report.obat.pdf', [
        //         'data' => $data,
        //         'jenis' => $jenis,
        //         'tanggal' => now()
        //     ])->setPaper('a4', 'portrait');

        //     return $pdf->stream("laporan_obat_{$jenis}_" . now()->format('Ymd_His') . ".pdf");
        // }

        public function printReportObat(Request $request)
        {
            $request->validate([
                'jenis' => 'required|in:expired,stok,laporan,data_obat',
            ]);

            $jenis = $request->jenis;
            $today = now();

            switch ($jenis) {
                case 'expired':
                    $data = Obat::with('dataObat')
                        ->whereDate('expired', '<', $today)
                        ->get();
                    break;

                case 'stok':
                    $data = Obat::with('dataObat')
                        ->where(function ($query) use ($today) {
                            $query->whereNull('expired')
                                ->orWhereDate('expired', '>=', $today->copy()->addMonth());
                        })
                        ->get()
                        ->groupBy(fn($item) => $item->dataObat->nama . '-' . $item->harga)
                        ->map(function ($group) {
                            return [
                                'nama' => $group->first()->dataObat->nama,
                                'kategori' => $group->first()->dataObat->kategori ?? '-',
                                'jenis' => $group->first()->dataObat->jenis ?? '-',
                                'no_batch' => $group->first()->no_batch,
                                'harga' => $group->first()->harga,
                                'stok' => $group->sum('stok'),
                            ];
                        })->values();
                    break;

                case 'laporan':
                    $data = Obat::with('dataObat')
                        ->where(function ($query) use ($today) {
                            $query->whereNull('expired')
                                ->orWhereDate('expired', '>=', $today);
                        })
                        ->get()
                        ->groupBy(fn($item) => $item->dataObat->nama . '-' . $item->harga)
                        ->map(function ($group) {
                            return [
                                'nama' => $group->first()->dataObat->nama,
                                'kategori' => $group->first()->dataObat->kategori ?? '-',
                                'jenis' => $group->first()->dataObat->jenis ?? '-',
                                'no_batch' => $group->first()->no_batch,
                                'harga' => $group->first()->harga,
                                'stok' => $group->sum('stok'),
                                'expired_terdekat' => $group->min('expired'),
                            ];
                        })->values();
                    break;

                case 'data_obat':
                    $data = DataObat::all(); // ambil semua data obat dari tabel data_obats
                    break;

                default:
                    abort(404);
            }

            $pdf = Pdf::loadView('report.obat.pdf', [
                'data' => $data,
                'jenis' => $jenis,
                'tanggal' => now()
            ])->setPaper('a4', 'portrait');

            return $pdf->stream("laporan_obat_{$jenis}_" . now()->format('Ymd_His') . ".pdf");
        }

        // end obat
    // end::report
}