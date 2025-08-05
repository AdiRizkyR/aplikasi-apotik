{{--  <!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan {{ ucfirst($jenis) }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 2cm;
        }

        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #000;
        }

        .kop-surat {
            text-align: center;
        }

        .garis {
            border-top: 2px solid #000;
            margin: 10px 0 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
            font-size: 11px;
        }

        .ttd {
            margin-top: 50px;
            width: 100%;
            text-align: right;
        }

        .ttd p {
            margin-bottom: 60px;
        }
    </style>
</head>

<body>
    <div class="kop-surat">
        <h2><strong>APOTEK ANTOKAN</strong></h2>
        <p>JL.</b> UJUNG GURUN, PADANG BARAT, KOTA PADANG</p>
        <p><b>SUMATERA BARAT</b></p>
    </div>
    <div class="garis"></div>

    @php
        $totalKeseluruhan = 0;
    @endphp

    <h3 style="text-align:center;">Laporan Penjualan</h3>
    <p style="text-align:center;">Periode: {{ \Carbon\Carbon::parse($start)->format('d-m-Y') }} s/d
        {{ \Carbon\Carbon::parse($end)->format('d-m-Y') }}</p>

    @if ($data->isEmpty())
        <p style="text-align:center;"><em>Tidak ada data penjualan pada periode ini.</em></p>
    @else
        @if (request()->waktu == 'tahun')
            @php
                $rekapPerBulan = collect([]);

                foreach ($data as $row) {
                    $bulan = \Carbon\Carbon::parse($row->tanggal_pesan)->format('F');
                    $totalPerRow = $row->detailPenjualans->sum(function ($detail) {
                        return $detail->jumlah_beli * ($detail->obat->harga ?? 0);
                    });
                    $rekapPerBulan[$bulan] = ($rekapPerBulan[$bulan] ?? 0) + $totalPerRow;
                }
            @endphp

            <table>
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>BULAN</th>
                        <th>TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($rekapPerBulan as $bulan => $total)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $bulan }}</td>
                            <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="2" style="text-align:right;"><strong>Total Keseluruhan</strong></td>
                        <td><strong>Rp {{ number_format($rekapPerBulan->sum(), 0, ',', '.') }}</strong></td>
                    </tr>
                </tbody>
            </table>
        @else
            <!-- Tabel lama jika bukan tahun -->
            @php $totalKeseluruhan = 0; @endphp
            <table>
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>ID PENJUALAN</th>
                        <th>PENANGGUNG JAWAB</th>
                        <th>PELANGGAN</th>
                        <th>TANGGAL</th>
                        <th>NAMA OBAT</th>
                        <th>JENIS</th>
                        <th>KATEGORI</th>
                        <th>HARGA</th>
                        <th>JUMLAH</th>
                        <th>SUBTOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $index => $row)
                        @php
                            $details = $row->detailPenjualans;
                            $rowspan = $details->count();
                        @endphp
                        @if ($rowspan > 0)
                            @foreach ($details as $i => $detail)
                                @php
                                    $obat = $detail->obat;
                                    $dataObat = $obat->dataObat ?? null;
                                    $subtotal = $detail->jumlah_beli * ($obat->harga ?? 0);
                                    $totalKeseluruhan += $subtotal;
                                @endphp
                                <tr>
                                    @if ($i == 0)
                                        <td rowspan="{{ $rowspan }}">{{ $index + 1 }}</td>
                                        <td rowspan="{{ $rowspan }}">{{ $row->id }}</td>
                                        <td rowspan="{{ $rowspan }}">{{ $row->user->name ?? '-' }}</td>
                                        <td rowspan="{{ $rowspan }}">{{ $row->pelanggan->nama ?? '-' }}</td>
                                        <td rowspan="{{ $rowspan }}">
                                            {{ \Carbon\Carbon::parse($row->tanggal_pesan)->format('d-m-Y') }}</td>
                                    @endif
                                    <td>{{ $dataObat->nama ?? '-' }}</td>
                                    <td>{{ $dataObat->jenis ?? '-' }}</td>
                                    <td>{{ $dataObat->kategori ?? '-' }}</td>
                                    <td>Rp {{ number_format($obat->harga ?? 0, 0, ',', '.') }}</td>
                                    <td>{{ $detail->jumlah_beli }}</td>
                                    <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        @endif
                    @endforeach
                    <tr>
                        <td colspan="10" style="text-align:right;"><strong>Total Keseluruhan</strong></td>
                        <td><strong>Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}</strong></td>
                    </tr>
                </tbody>
            </table>
        @endif
    @endif

    <div class="ttd">
        <p>Padang, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        <p>( ........................................ )</p>
    </div>
</body>

</html>  --}}


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan {{ ucfirst($jenis) }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 2cm;
        }

        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #000;
        }

        .kop-surat {
            text-align: center;
        }

        .garis {
            border-top: 2px solid #000;
            margin: 10px 0 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
            font-size: 11px;
        }

        .ttd {
            margin-top: 50px;
            width: 100%;
            text-align: right;
        }

        .ttd p {
            margin-bottom: 60px;
        }

        .periode-info {
            margin-top: 10px;
            margin-bottom: -10px;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="kop-surat">
        <h2><strong>APOTEK ANTOKAN</strong></h2>
        <p>JL. UJUNG GURUN, PADANG BARAT, KOTA PADANG</p>
        <p><b>SUMATERA BARAT</b></p>
    </div>
    <div class="garis"></div>

    @php
        $totalKeseluruhan = 0;

        // Judul berdasarkan jenis waktu
        $judul = 'Laporan Penjualan';
        if (request()->waktu == 'tanggal') {
            $judul .= ' Pertanggal';
        } elseif (request()->waktu == 'bulan') {
            $judul .= ' Perbulan';
        } elseif (request()->waktu == 'tahun') {
            $judul .= ' Pertahun';
        } elseif (request()->waktu == 'periode') {
            $judul .= ' Pertanggal';
        }

        // Info periode
        /*
        $infoPeriode = '';
        if (request()->waktu == 'tanggal') {
            $infoPeriode = 'Tanggal : ' . \Carbon\Carbon::parse($start)->format('d-m-Y');
        } elseif (request()->waktu == 'bulan') {
            $infoPeriode = 'Bulan : ' . \Carbon\Carbon::parse($start)->format('m-Y');
        } elseif (request()->waktu == 'tahun') {
            $infoPeriode = 'Tahun : ' . \Carbon\Carbon::parse($start)->format('Y');
        }
        */
        // Info periode
        $infoPeriode = '';
        if (request()->waktu == 'tanggal') {
            $infoPeriode = 'Tanggal : ' . \Carbon\Carbon::parse($start)->format('d-m-Y');
        } elseif (request()->waktu == 'bulan') {
            $infoPeriode = 'Bulan : ' . \Carbon\Carbon::parse($start)->format('m-Y');
        } elseif (request()->waktu == 'tahun') {
            $infoPeriode = 'Tahun : ' . \Carbon\Carbon::parse($start)->format('Y');
        } elseif (request()->waktu == 'periode') {
            $infoPeriode =
                'Periode : ' .
                \Carbon\Carbon::parse($start)->format('d-m-Y') .
                ' s/d ' .
                \Carbon\Carbon::parse($end)->format('d-m-Y');
        }
    @endphp

    <h3 style="text-align:center;">{{ $judul }}</h3>

    @if ($data->isEmpty())
        <p style="text-align:center;"><em>Tidak ada data penjualan pada periode ini.</em></p>
    @else
        @if ($infoPeriode)
            <p class="periode-info"><strong>{{ $infoPeriode }}</strong></p>
        @endif

        @if (request()->waktu == 'tahun')
            @php
                $urutanBulan = [
                    'January' => 'Januari',
                    'February' => 'Februari',
                    'March' => 'Maret',
                    'April' => 'April',
                    'May' => 'Mei',
                    'June' => 'Juni',
                    'July' => 'Juli',
                    'August' => 'Agustus',
                    'September' => 'September',
                    'October' => 'Oktober',
                    'November' => 'November',
                    'December' => 'Desember',
                ];

                // Inisialisasi semua bulan dengan 0
                $rekapPerBulan = collect([]);
                foreach ($urutanBulan as $bulanKey => $bulanLabel) {
                    $rekapPerBulan[$bulanKey] = 0;
                }

                // Isi total penjualan jika ada
                foreach ($data as $row) {
                    $bulan = \Carbon\Carbon::parse($row->tanggal_pesan)->format('F');
                    $totalPerRow = $row->detailPenjualans->sum(function ($detail) {
                        return $detail->jumlah_beli * ($detail->obat->harga ?? 0);
                    });
                    if (isset($rekapPerBulan[$bulan])) {
                        $rekapPerBulan[$bulan] += $totalPerRow;
                    }
                }
            @endphp

            <table>
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>BULAN</th>
                        <th>TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($urutanBulan as $bulanKey => $bulanLabel)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $bulanLabel }}</td>
                            <td>Rp {{ number_format($rekapPerBulan[$bulanKey], 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="2" style="text-align:right;"><strong>Total Keseluruhan</strong></td>
                        <td><strong>Rp {{ number_format($rekapPerBulan->sum(), 0, ',', '.') }}</strong></td>
                    </tr>
                </tbody>
            </table>
        @else
            {{-- Tabel detail transaksi --}}
            <table>
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>ID PENJUALAN</th>
                        <th>TANGGAL PESAN</th>
                        <th>NAMA OBAT</th>
                        <th>JUMLAH BELI</th>
                        <th>HARGA</th>
                        <th>SUBTOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $index => $row)
                        @php
                            $details = $row->detailPenjualans;
                            $rowspan = $details->count();
                        @endphp
                        @if ($rowspan > 0)
                            @foreach ($details as $i => $detail)
                                @php
                                    $obat = $detail->obat;
                                    $dataObat = $obat->dataObat ?? null;
                                    $subtotal = $detail->jumlah_beli * ($obat->harga ?? 0);
                                    $totalKeseluruhan += $subtotal;
                                @endphp
                                <tr>
                                    @if ($i == 0)
                                        <td rowspan="{{ $rowspan }}">{{ $index + 1 }}</td>
                                        <td rowspan="{{ $rowspan }}">
                                            PJL{{ str_pad($row->id, 5, '0', STR_PAD_LEFT) }}</td>
                                        <td rowspan="{{ $rowspan }}">
                                            {{ \Carbon\Carbon::parse($row->tanggal_pesan)->format('d-m-Y') }}</td>
                                    @endif
                                    <td>{{ $dataObat->nama ?? '-' }}</td>
                                    <td>{{ $detail->jumlah_beli }}</td>
                                    <td>Rp {{ number_format($obat->harga ?? 0, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        @endif
                    @endforeach
                    <tr>
                        <td colspan="6" style="text-align:right;"><strong>Total Keseluruhan</strong></td>
                        <td><strong>Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}</strong></td>
                    </tr>
                </tbody>
            </table>
        @endif
    @endif

    <div class="ttd">
        <p>Padang, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        <p>( ........................................ )</p>
    </div>
</body>

</html>
