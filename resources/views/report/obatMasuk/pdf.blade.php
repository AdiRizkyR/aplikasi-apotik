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
                            <td>{{ $detail->jumlah_beli }}</td>
                            <td>Rp {{ number_format($detail->harga_beli, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($detail->harga_jual ?? 0, 0, ',', '.') }}</td>
                            <td>{{ \Carbon\Carbon::parse($detail->expired)->format('d-m-Y') }}</td>
                            <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                @endforeach

                <tr>
                    <td colspan="10" style="text-align: right;"><strong>Total Keseluruhan</strong></td>
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
