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

    <h3 style="text-align:center;">Laporan Penjualan</h3>
    <p style="text-align:center;">Periode: {{ \Carbon\Carbon::parse($start)->format('d-m-Y') }} s/d
        {{ \Carbon\Carbon::parse($end)->format('d-m-Y') }}</p>

    @if ($data->isEmpty())
        <p style="text-align:center;"><em>Tidak ada data penjualan pada periode ini.</em></p>
    @else
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
                                $subtotal = $detail->jumlah_beli * $obat->harga;
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
                                <td>Rp {{ number_format($obat->harga, 0, ',', '.') }}</td>
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

    <div class="ttd">
        <p>Padang, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        <p>( ........................................ )</p>
    </div>
</body>

</html>
