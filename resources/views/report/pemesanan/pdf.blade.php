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
            line-height: 1.4;
        }

        .kop-surat h2 {
            margin: 0;
            font-size: 18px;
        }

        .kop-surat p {
            margin: 0;
            font-size: 12px;
        }

        .garis {
            border-top: 2px solid #000;
            margin: 10px 0 20px;
        }

        .judul-laporan {
            text-align: center;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            font-size: 11px;
            text-align: center;
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
        <h2>E-Apotik</h2>
        <p>Jl. Dummy Alamat No.123, Kecamatan Contoh, Kota Fiktif</p>
        <p>Provinsi Sumatera Barat</p>
    </div>

    <div class="garis"></div>

    @php
        use Illuminate\Support\Carbon;

        $labelJenis = str_replace('_', ' ', strtolower($jenis));
        $labelJenis = rtrim($labelJenis, 's');
        $totalKeseluruhan = 0;
    @endphp

    <div class="judul-laporan">
        <h3>Laporan Data {{ ucfirst($labelJenis) }}</h3>
        <p>Periode: {{ \Carbon\Carbon::parse($start)->format('d-m-Y') }} s/d
            {{ \Carbon\Carbon::parse($end)->format('d-m-Y') }}</p>
    </div>

    @if ($data->isEmpty())
        <p style="text-align:center;">
            <em>Tidak ada data dari tanggal {{ \Carbon\Carbon::parse($start)->format('d-m-Y') }} sampai
                {{ \Carbon\Carbon::parse($end)->format('d-m-Y') }}</em>
        </p>
    @else
        @if ($jenis === 'pemesanans_tahun')
            <!-- Tabel Rekap Tahunan -->
            @php
                $bulanLabels = [
                    1 => 'Januari',
                    2 => 'Februari',
                    3 => 'Maret',
                    4 => 'April',
                    5 => 'Mei',
                    6 => 'Juni',
                    7 => 'Juli',
                    8 => 'Agustus',
                    9 => 'September',
                    10 => 'Oktober',
                    11 => 'November',
                    12 => 'Desember',
                ];

                $rekap = [];

                foreach ($data as $item) {
                    $bulan = Carbon::parse($item->tanggal_pesan)->month;
                    $jumlah = 0;

                    foreach ($item->detailPemesanans as $d) {
                        $jumlah += $d->jumlah_beli * $d->harga_beli;
                    }

                    if (!isset($rekap[$bulan])) {
                        $rekap[$bulan] = 0;
                    }

                    $rekap[$bulan] += $jumlah;
                }
            @endphp

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Bulan</th>
                        <th>Total Pemesanan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bulanLabels as $bulan => $namaBulan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $namaBulan }}</td>
                            <td>
                                Rp {{ number_format($rekap[$bulan] ?? 0, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <!-- Tabel Detail (Semua atau Bulan) -->
            <table>
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>ID PEMESANAN</th>
                        <th>PENANGGUNG JAWAB</th>
                        <th>SUPPLIER</th>
                        <th>TANGGAL</th>
                        <th>NAMA OBAT</th>
                        <th>JENIS</th>
                        <th>KATEGORI</th>
                        <th>HARGA BELI</th>
                        <th>JUMLAH</th>
                        <th>SUBTOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $index => $row)
                        @php
                            $details = $row->detailPemesanans;
                            $rowspan = $details->count();
                        @endphp

                        @if ($rowspan > 0)
                            @foreach ($details as $i => $detail)
                                @php
                                    $subtotal = $detail->jumlah_beli * $detail->harga_beli;
                                    $totalKeseluruhan += $subtotal;
                                @endphp
                                <tr>
                                    @if ($i == 0)
                                        <td rowspan="{{ $rowspan }}">{{ $index + 1 }}</td>
                                        <td rowspan="{{ $rowspan }}">{{ $row->id }}</td>
                                        <td rowspan="{{ $rowspan }}">{{ optional($row->user)->name }}</td>
                                        <td rowspan="{{ $rowspan }}">{{ optional($row->supplier)->nama }}</td>
                                        <td rowspan="{{ $rowspan }}">
                                            {{ \Carbon\Carbon::parse($row->tanggal_pesan)->format('d-m-Y') }}</td>
                                    @endif
                                    <td>{{ $detail->dataObat->nama ?? '-' }}</td>
                                    <td>{{ $detail->dataObat->jenis ?? '-' }}</td>
                                    <td>{{ $detail->dataObat->kategori ?? '-' }}</td>
                                    <td>Rp {{ number_format($detail->harga_beli, 0, ',', '.') }}</td>
                                    <td>{{ $detail->jumlah_beli }}</td>
                                    <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $row->id }}</td>
                                <td>{{ optional($row->user)->name }}</td>
                                <td>{{ optional($row->supplier)->nama }}</td>
                                <td>{{ \Carbon\Carbon::parse($row->tanggal_pesan)->format('d-m-Y') }}</td>
                                <td colspan="6" style="text-align:center;"><em>Tidak ada detail pemesanan</em></td>
                            </tr>
                        @endif
                    @endforeach

                    <!-- TOTAL KESELURUHAN -->
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

</html>
