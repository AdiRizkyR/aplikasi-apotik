<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Obat</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        h2,
        h3 {
            text-align: center;
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
        }

        .ttd {
            margin-top: 40px;
            text-align: right;
        }

        .ttd p {
            margin-bottom: 60px;
        }
    </style>
</head>

<body>
    <h2>APOTEK ANTOKAN</h2>
    <p style="text-align:center;">JL. UJUNG GURUN, PADANG BARAT, KOTA PADANG - SUMATERA BARAT</p>
    <hr>
    <h3>
        @switch($jenis)
            @case('expired')
                Laporan Obat Expired
            @break

            @case('stok')
                Laporan Stok Obat
            @break

            @case('laporan')
                Laporan Obat
            @break

            @case('data_obat')
                Laporan Data Obat
            @break
        @endswitch
    </h3>

    {{--  @if ($data->isEmpty())
        <p style="text-align:center;"><em>Data tidak tersedia</em></p>
    @else
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Obat</th>
                    <th>Jenis</th>
                    <th>Kategori</th>
                    <th>Nomor Batch</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    @if ($jenis === 'laporan')
                        <th>Expired Terdekat</th>
                    @elseif ($jenis === 'expired')
                        <th>Expired</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item['nama'] ?? $item->dataObat->nama }}</td>
                        <td>{{ $item['jenis'] ?? ($item->dataObat->jenis ?? '-') }}</td>
                        <td>{{ $item['kategori'] ?? ($item->dataObat->kategori ?? '-') }}</td>
                        <td>{{ $item['no_batch'] ?? $item->no_batch }}</td>
                        <td>Rp {{ number_format($item['harga'] ?? $item->harga, 0, ',', '.') }}</td>
                        <td>{{ $item['stok'] ?? $item->stok }}</td>
                        @if ($jenis === 'laporan')
                            <td>{{ \Carbon\Carbon::parse($item['expired_terdekat'])->format('d-m-Y') }}</td>
                        @elseif ($jenis === 'expired')
                            <td>{{ \Carbon\Carbon::parse($item->expired)->format('d-m-Y') }}</td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif  --}}

    @if ($data->isEmpty())
        <p style="text-align:center;"><em>Data tidak tersedia</em></p>
    @else
        @if ($jenis === 'data_obat')
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID OBAT</th>
                        <th>Nama Obat</th>
                        <th>Jenis</th>
                        <th>Kategori</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->jenis }}</td>
                            <td>{{ $item->kategori }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Obat</th>
                        <th>Jenis</th>
                        <th>Kategori</th>
                        <th>Nomor Batch</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        @if ($jenis === 'laporan')
                            <th>Expired Terdekat</th>
                        @elseif ($jenis === 'expired')
                            <th>Expired</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item['nama'] ?? $item->dataObat->nama }}</td>
                            <td>{{ $item['jenis'] ?? ($item->dataObat->jenis ?? '-') }}</td>
                            <td>{{ $item['kategori'] ?? ($item->dataObat->kategori ?? '-') }}</td>
                            <td>{{ $item['no_batch'] ?? $item->no_batch }}</td>
                            <td>Rp {{ number_format($item['harga'] ?? $item->harga, 0, ',', '.') }}</td>
                            <td>{{ $item['stok'] ?? $item->stok }}</td>
                            @if ($jenis === 'laporan')
                                <td>{{ \Carbon\Carbon::parse($item['expired_terdekat'])->format('d-m-Y') }}</td>
                            @elseif ($jenis === 'expired')
                                <td>{{ \Carbon\Carbon::parse($item->expired)->format('d-m-Y') }}</td>
                            @endif
                        </tr>
                    @endforeach
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
