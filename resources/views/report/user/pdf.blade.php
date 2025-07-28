<!DOCTYPE html>
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

</html>
