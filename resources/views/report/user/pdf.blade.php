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
        <h2><strong>APOTEK ANTOKAN</strong></h2>
        <p><b>JL.</b> UJUNG GURUN, PADANG BARAT, KOTA PADANG</p>
        <p><b>SUMATERA BARAT</b></p>
    </div>

    <div class="garis"></div>

    @php
        $labelJenis = ucfirst(rtrim(strtolower($jenis), 's'));
    @endphp

    <div class="judul-laporan">
        <h3>Laporan Data {{ $labelJenis }}</h3>
    </div>

    @if ($data->isEmpty())
        <p style="text-align:center;"><em>Data {{ $labelJenis }} tidak tersedia</em></p>
    @else
        <table>
            <thead>
                <tr>
                    <th>NO</th>
                    @foreach ($data->first()->getAttributes() as $col => $val)
                        @continue($col === 'remember_token')
                        @continue($jenis !== 'users' && in_array($col, ['password']))
                        @continue(in_array($col, ['created_at', 'updated_at']))

                        <th>{{ strtoupper(str_replace('_', ' ', $col)) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $index => $row)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        @foreach ($row->getAttributes() as $col => $val)
                            @continue($col === 'remember_token')
                            @continue($jenis !== 'users' && in_array($col, ['password']))
                            @continue(in_array($col, ['created_at', 'updated_at']))

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
