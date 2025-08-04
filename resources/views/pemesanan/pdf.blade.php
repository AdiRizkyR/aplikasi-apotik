{{-- File: resources/views/pemesanan/pdf.blade.php --}}
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
        <h2><b>APOTEK ANTOKAN</b></h2>
        <p><b>JL.</b> UJUNG GURUN, PADANG BARAT, KOTA PADANG</p>
        <p><strong>SUMATERA BARAT</strong></p>
    </div>

    <div class="garis"></div>

    @php
        $labelJenis = str_replace('_', ' ', strtolower($jenis));
        $labelJenis = rtrim($labelJenis, 's');
    @endphp

    <div class="judul-laporan">
        <h3>Laporan Faktur {{ ucfirst($labelJenis) }}</h3>
    </div>

    @if ($jenis == 'pemesanans')
        @foreach ($data as $index => $pemesanan)
            <table>
                <tr>
                    <th style="text-align: left">ID Pemesanan</th>
                    {{--  <td>{{ $pemesanan->id ?? '-' }}</td>  --}}
                    <td>
                        {{ isset($pemesanan->id) ? 'PMS' . str_pad($pemesanan->id, 5, '0', STR_PAD_LEFT) : '-' }}
                    </td>
                </tr>
                <tr>
                    <th style="text-align: left">Penanggung Jawab</th>
                    <td>{{ $pemesanan->user->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th style="text-align: left">Supplier</th>
                    <td>{{ $pemesanan->supplier->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <th style="text-align: left">Tanggal Pesan</th>
                    <td>{{ \Carbon\Carbon::parse($pemesanan->tanggal_pesan)->format('d-m-Y') }}</td>
                </tr>
            </table>

            <h5 style="margin-top: 10px;">Detail Obat Dipesan</h5>
            <table>
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>Nama Obat</th>
                        <th>Jenis</th>
                        <th>Kategori</th>
                        <th>Jumlah Beli</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pemesanan->detailPemesanans as $i => $detail)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $detail->dataObat->nama ?? '-' }}</td>
                            <td>{{ $detail->dataObat->jenis ?? '-' }}</td>
                            <td>{{ $detail->dataObat->kategori ?? '-' }}</td>
                            <td>{{ $detail->jumlah_beli }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <br>
        @endforeach
    @else
        {{-- Versi default jika jenis bukan pemesanan --}}
        <table>
            <thead>
                <tr>
                    <th>NO</th>
                    @foreach ($data->first()->getAttributes() as $col => $val)
                        @continue(in_array($col, ['created_at', 'updated_at', 'remember_token']))
                        <th>{{ strtoupper(str_replace('_', ' ', $col)) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $index => $row)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        @foreach ($row->getAttributes() as $col => $val)
                            @continue(in_array($col, ['created_at', 'updated_at', 'remember_token']))
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
