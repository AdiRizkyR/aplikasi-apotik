{{--  <!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan {{ ucfirst($jenis) }}</title>
    <style>
        @page {
            size: A4;
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
        $labelJenis = str_replace('_', ' ', strtolower($jenis));
        $labelJenis = rtrim($labelJenis, 's'); // hapus 's' di akhir
    @endphp

    <div class="judul-laporan">
        <h3>Laporan Data {{ ucfirst($labelJenis) }}</h3>
        <p>Periode: {{ \Carbon\Carbon::parse($start)->format('d-m-Y') }} s/d
            {{ \Carbon\Carbon::parse($end)->format('d-m-Y') }}</p>
    </div>

    @if ($data->isEmpty())
        <p style="text-align:center;">
            @if ($start && $end)
                <em>Tidak ada data dari tanggal {{ \Carbon\Carbon::parse($start)->format('d-m-Y') }} sampai
                    {{ \Carbon\Carbon::parse($end)->format('d-m-Y') }}</em>
            @else
                <em>Belum ada data dari tabel {{ $labelJenis }}</em>
            @endif
        </p>
    @else
        <table>
            <thead>
                <tr>
                    <th>NO</th>
                    @foreach ($data->first()->getAttributes() as $col => $val)
                        @continue(in_array($col, ['created_at', 'updated_at', 'remember_token']))

                        @php
                            // Ganti id menjadi "ID [TABEL]"
                            if ($col === 'id') {
                                $colLabel = 'ID ' . strtoupper($labelJenis);
                            }
                            // Ganti relasi user_id, pelanggan_id, supplier_id ke nama mereka
                            elseif (in_array($col, ['user_id', 'pelanggan_id', 'supplier_id'])) {
                                $colLabel = 'NAMA ' . strtoupper(str_replace('_id', '', $col));
                            } else {
                                $colLabel = strtoupper(str_replace('_', ' ', $col));
                            }
                        @endphp

                        <th>{{ $colLabel }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $index => $row)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        @foreach ($row->getAttributes() as $col => $val)
                            @continue(in_array($col, ['created_at', 'updated_at', 'remember_token']))

                            @php
                                // Ganti relasi id menjadi nama
                                if ($col === 'user_id') {
                                    $val = optional($row->user)->name;
                                } elseif ($col === 'pelanggan_id') {
                                    $val = optional($row->pelanggan)->nama;
                                } elseif ($col === 'supplier_id') {
                                    $val = optional($row->supplier)->nama;
                                }
                            @endphp

                            <td>{{ $val }}</td>
                        @endforeach
                    </tr>
                @endforeach
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
        }

        .ttd {
            margin-top: 50px;
            width: 100%;
            text-align: right;
        }

        .ttd p {
            margin-bottom: 60px;
        }

        .sub-judul {
            margin-top: 15px;
            font-weight: bold;
            font-size: 14px;
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
        $labelJenis = str_replace('_', ' ', strtolower($jenis));
        $labelJenis = rtrim($labelJenis, 's');
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
        @if (in_array($jenis, ['penjualans', 'pemesanans', 'obat_masuks']))
            @foreach ($data as $i => $item)
                <div class="sub-judul">#{{ $i + 1 }}</div>

                <table>
                    <tbody>
                        <tr>
                            <td><strong>ID</strong></td>
                            <td>{{ $item->id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal</strong></td>
                            <td>{{ $item->created_at->format('d-m-Y') }}</td>
                        </tr>

                        @if ($jenis === 'penjualans')
                            <tr>
                                <td><strong>User</strong></td>
                                <td>{{ optional($item->user)->name }} ({{ optional($item->user)->username }})</td>
                            </tr>
                            <tr>
                                <td><strong>Pelanggan</strong></td>
                                <td>{{ optional($item->pelanggan)->nama }}</td>
                            </tr>
                        @elseif ($jenis === 'pemesanans')
                            <tr>
                                <td><strong>User</strong></td>
                                <td>{{ optional($item->user)->name }} ({{ optional($item->user)->username }})</td>
                            </tr>
                            <tr>
                                <td><strong>Supplier</strong></td>
                                <td>{{ optional($item->supplier)->nama }}</td>
                            </tr>
                        @elseif ($jenis === 'obat_masuks')
                            <tr>
                                <td><strong>Pemesanan Oleh</strong></td>
                                <td>{{ optional($item->pemesanan->user)->name }}
                                    ({{ optional($item->pemesanan->user)->username }})
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Supplier</strong></td>
                                <td>{{ optional($item->pemesanan->supplier)->nama }}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Obat</th>
                            <th>Jumlah</th>
                            @if ($jenis !== 'obat_masuks')
                                <th>Harga</th>
                                <th>Total</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $details = collect();
                            if ($jenis === 'penjualans') {
                                $details = $item->detailPenjualans;
                            } elseif ($jenis === 'pemesanans') {
                                $details = $item->detailPemesanans;
                            } elseif ($jenis === 'obat_masuks') {
                                $details = $item->detailObatMasuks;
                            }
                        @endphp

                        @foreach ($details as $d => $det)
                            <tr>
                                <td>{{ $d + 1 }}</td>
                                <td>
                                    {{ $det->dataObat->nama ?? (optional($det->obat->dataObat)->nama ?? '-') }}
                                </td>
                                <td>{{ $det->jumlah ?? $det->jumlah_beli }}</td>
                                @if ($jenis !== 'obat_masuks')
                                    @php
                                        $harga = $det->harga_beli ?? (optional($det->obat)->harga ?? 0);
                                        $jumlah = $det->jumlah ?? $det->jumlah_beli;
                                        $total = $harga * $jumlah;
                                    @endphp
                                    <td>{{ number_format($harga) }}</td>
                                    <td>{{ number_format($total) }}</td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endforeach
        @else
            <table>
                <thead>
                    <tr>
                        <th>NO</th>
                        @foreach ($data->first()->getAttributes() as $col => $val)
                            @continue(in_array($col, ['created_at', 'updated_at', 'remember_token']))
                            @php
                                $colLabel = match ($col) {
                                    'id' => 'ID ' . strtoupper($labelJenis),
                                    'user_id' => 'NAMA USER',
                                    'supplier_id' => 'NAMA SUPPLIER',
                                    'pelanggan_id' => 'NAMA PELANGGAN',
                                    default => strtoupper(str_replace('_', ' ', $col)),
                                };
                            @endphp
                            <th>{{ $colLabel }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $index => $row)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            @foreach ($row->getAttributes() as $col => $val)
                                @continue(in_array($col, ['created_at', 'updated_at', 'remember_token']))
                                @php
                                    if ($col === 'user_id') {
                                        $val = optional($row->user)->name . ' (' . optional($row->user)->username . ')';
                                    } elseif ($col === 'pelanggan_id') {
                                        $val = optional($row->pelanggan)->nama;
                                    } elseif ($col === 'supplier_id') {
                                        $val = optional($row->supplier)->nama;
                                    }
                                @endphp
                                <td>{{ $val }}</td>
                            @endforeach
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
