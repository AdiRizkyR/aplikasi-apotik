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
        }

        .kop-surat {
            text-align: center;
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
        $totalKeseluruhan = 0;
    @endphp

    <div class="judul-laporan">
        <h3>Laporan Obat Masuk</h3>
        <p>Periode: {{ \Carbon\Carbon::parse($start)->format('d-m-Y') }} s/d
            {{ \Carbon\Carbon::parse($end)->format('d-m-Y') }}</p>
    </div>

    @if ($data->isEmpty())
        <p style="text-align: center;">
            <em>Tidak ada data pada periode ini.</em>
        </p>
    @else
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Pemesanan</th>
                    <th>Tanggal Terima</th>
                    <th>Penanggung Jawab</th>
                    <th>Supplier</th>
                    <th>Nama Obat</th>
                    <th>No. Batch</th>
                    <th>Jumlah</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Expired</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $index => $row)
                    @foreach ($row->detailObatMasuks as $i => $detail)
                        @php
                            $subtotal = $detail->jumlah_beli * $detail->harga_beli;
                            $totalKeseluruhan += $subtotal;
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->pemesanan->id ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($row->tanggal_terima)->format('d-m-Y') }}</td>
                            <td>{{ $row->pemesanan->user->name ?? '-' }}</td>
                            <td>{{ $row->pemesanan->supplier->nama ?? '-' }}</td>
                            <td>{{ $detail->dataObat->nama ?? '-' }}</td>
                            <td>{{ $detail->no_batch ?? '-' }}</td>
                            <td>{{ $detail->jumlah_beli }}</td>
                            <td>Rp {{ number_format($detail->harga_beli, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($detail->harga_jual ?? 0, 0, ',', '.') }}</td>
                            <td>{{ \Carbon\Carbon::parse($detail->expired)->format('d-m-Y') }}</td>
                            <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                @endforeach

                <tr>
                    <td colspan="11" style="text-align: right;"><strong>Total Keseluruhan</strong></td>
                    <td><strong>Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}</strong></td>
                </tr>
            </tbody>
        </table>
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

        .periode-info {
            margin-bottom: 10px;
            font-size: 12px;
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
        <h2><strong>APOTEK ANTOKAN</strong></h2>
        <p><b>JL.</b> UJUNG GURUN, PADANG BARAT, KOTA PADANG</p>
        <p><b>SUMATERA BARAT</b></p>
    </div>

    <div class="garis"></div>

    @php
        $judulJenis = match ($waktu) {
            'tanggal' => 'Pertanggal',
            'bulan' => 'Perbulan',
            'tahun' => 'Pertahun',
            default => '',
        };
    @endphp

    <div class="judul-laporan">
        <h3>Laporan Obat Masuk {{ $judulJenis }}</h3>
    </div>

    @if ($data->isEmpty())
        <p style="text-align: center;"><em>Tidak ada data pada periode ini.</em></p>
    @else
        @php
            $periodeLabel = '';
            if ($waktu === 'tanggal') {
                $periodeLabel = 'Tanggal : ' . \Carbon\Carbon::parse($start)->format('d-m-Y');
            } elseif ($waktu === 'bulan') {
                $periodeLabel = 'Bulan : ' . \Carbon\Carbon::parse($start)->format('m-Y');
            } elseif ($waktu === 'tahun') {
                $periodeLabel = 'Tahun : ' . \Carbon\Carbon::parse($start)->format('Y');
            }
        @endphp

        @if ($periodeLabel)
            <p class="periode-info">{{ $periodeLabel }}</p>
        @endif

        @if ($waktu === 'tahun')
            @php
                $bulanList = [
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

                $totalPerBulan = [];

                foreach ($data as $row) {
                    foreach ($row->detailObatMasuks as $detail) {
                        $bulan = \Carbon\Carbon::parse($row->tanggal_terima)->month;
                        $subtotal = $detail->jumlah_beli * $detail->harga_beli;
                        $totalPerBulan[$bulan] = ($totalPerBulan[$bulan] ?? 0) + $subtotal;
                    }
                }

                ksort($totalPerBulan);
                $grandTotal = array_sum($totalPerBulan);
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
                    @php $grandTotal = 0; @endphp
                    @foreach ($bulanList as $bulan => $namaBulan)
                        @php
                            $total = $totalPerBulan[$bulan] ?? 0;
                            $grandTotal += $total;
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $namaBulan }}</td>
                            <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="2"><strong>Total Keseluruhan</strong></td>
                        <td><strong>Rp {{ number_format($grandTotal, 0, ',', '.') }}</strong></td>
                    </tr>
                </tbody>
            </table>
        @else
            @php $totalKeseluruhan = 0; @endphp
            <table>
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>ID PEMESANAN</th>
                        <th>TANGGAL TERIMA</th>
                        {{--  <th>PENANGGUNG JAWAB</th>  --}}
                        <th>SUPPLIER</th>
                        <th>NAMA OBAT</th>
                        {{--  <th>NO BATCH</th>  --}}
                        <th>EXPIRED</th>
                        <th>STOK</th>
                        <th>HARGA SATUAN</th>
                        {{--  <th>HARGA JUAL</th>  --}}
                        <th>SUBTOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $row)
                        @foreach ($row->detailObatMasuks as $detail)
                            @php
                                $subtotal = $detail->jumlah_beli * $detail->harga_beli;
                                $totalKeseluruhan += $subtotal;
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row->pemesanan->id ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($row->tanggal_terima)->format('d-m-Y') }}</td>
                                {{--  <td>{{ $row->pemesanan->user->name ?? '-' }}</td>  --}}
                                <td>{{ $row->pemesanan->supplier->nama ?? '-' }}</td>
                                <td>{{ $detail->dataObat->nama ?? '-' }}</td>
                                {{--  <td>{{ $detail->no_batch ?? '-' }}</td>  --}}
                                <td>{{ \Carbon\Carbon::parse($detail->expired)->format('d-m-Y') }}</td>
                                <td>{{ $detail->jumlah_beli }}</td>
                                <td>Rp {{ number_format($detail->harga_beli, 0, ',', '.') }}</td>
                                {{--  <td>Rp {{ number_format($detail->harga_jual ?? 0, 0, ',', '.') }}</td>  --}}
                                <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                    <tr>
                        <td colspan="8" style="text-align: right;"><strong>Total Keseluruhan</strong></td>
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
