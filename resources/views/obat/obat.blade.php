{{--  @extends('layout.index')
@section('title-page', 'Obat')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">E-Apotik</a></li>
    <li class="breadcrumb-item active">Obat</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Data Obat</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr class="text-center">
                        <th>NO</th>
                        <th>NAMA OBAT</th>
                        <th>STOK</th>
                        <th>HARGA</th>
                        <th>EXPIRED</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse ($obats as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item['nama'] }}</td>
                            <td>{{ $item['stok'] }}</td>
                            <td>Rp{{ number_format($item['harga'], 0, ',', '.') }}</td>
                            <td>{{ \Carbon\Carbon::parse($item['expired'])->format('d-m-Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data obat.</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
@endsection  --}}

@extends('layout.index')
@section('title-page', 'Obat')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">E-Apotik</a></li>
    <li class="breadcrumb-item active">Obat</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Data Obat</h3>
        </div>

        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>NAMA OBAT</th>
                        <th>STOK</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($obats as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item['nama'] }}</td>
                            <td>{{ $item['stok'] }}</td>
                            <td>
                                <button class="btn btn-sm btn-info" data-toggle="modal"
                                    data-target="#detailModal-{{ $item['id'] }}">
                                    Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data obat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @foreach ($obats as $item)
        <div class="modal fade" id="detailModal-{{ $item['id'] }}" tabindex="-1" role="dialog" data-backdrop="static"
            data-keyboard="false" aria-labelledby="modalTitle-{{ $item['id'] }}" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle-{{ $item['id'] }}">
                            Nama Obat : {{ $item['nama'] }} <!--| Rp{{ number_format($item['harga'], 0, ',', '.') }}-->
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>NOMOR BATCH</th>
                                    <th>STOK</th>
                                    <th>HARGA</th>
                                    <th>EXPIRED</th>
                                    <th>STATUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $batch = $allObats->filter(function ($o) use ($item) {
                                        return $o->dataObat->nama === $item['nama'];
                                    });
                                @endphp
                                @foreach ($batch as $index => $b)
                                    @php
                                        $today = \Carbon\Carbon::now();
                                        $expired = \Carbon\Carbon::parse($b->expired);
                                        $diffInDays = $today->diffInDays($expired, false);

                                        if ($diffInDays < 0) {
                                            $badgeColor = 'danger';
                                            $badgeText = 'Expired';
                                            $tooltip = 'Obat sudah expired';
                                        } elseif ($diffInDays < 30) {
                                            $badgeColor = 'warning';
                                            $badgeText = 'Akan Expired';
                                            $tooltip = 'Data ini sudah akan expired';
                                        } else {
                                            $badgeColor = 'success';
                                            $badgeText = 'Aktif';
                                            $tooltip = "Masih tersisa {$diffInDays} hari sebelum expired";
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $b->no_batch }}</td>
                                        <td>{{ $b->stok }}</td>
                                        <td>Rp{{ number_format($b->harga, 0, ',', '.') }}</td>
                                        <td>{{ $expired->format('d-m-Y') }}</td>
                                        <td>
                                            <span class="badge badge-{{ $badgeColor }}" data-toggle="tooltip"
                                                data-placement="top" title="{{ $tooltip }}">
                                                {{ $badgeText }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@push('scripts')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap 4 JS Bundle (termasuk Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@endpush
