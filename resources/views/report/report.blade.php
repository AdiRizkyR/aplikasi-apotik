{{--  @extends('layout.index')
@section('title-page', 'Laporan')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">E-Apotik</a></li>
    <li class="breadcrumb-item active">Laporan</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Pelaporan</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('report.export.pdf') }}" method="GET" target="_blank">
                <div class="row">
                    <div class="col-md-4">
                        <label>Jenis Laporan</label>
                        <select name="jenis" class="form-control" required id="jenis-laporan">
                            <option value="">-- Pilih Jenis --</option>
                            <option value="users">Data User</option>
                            <option value="suppliers">Data Supplier</option>
                            <option value="pelanggans">Data Pelanggan</option>
                            <option value="pemesanans">Data Pemesanan</option>
                            <option value="obat_masuks">Data Obat Masuk</option>
                            <option value="obats">Data Obat</option>
                            <option value="penjualans">Data Penjualan</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Dari Tanggal</label>
                        <input type="date" name="start" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label>Sampai Tanggal</label>
                        <input type="date" name="end" class="form-control" required>
                    </div>
                </div>

                <div class="row mt-3" id="filter-opsional" style="display: none;">
                    <div class="col-md-4">
                        <label>Filter Berdasarkan</label>
                        <select name="filter_id" class="form-control" id="filter-by">
                            <option value="">-- Semua --</option>
                            <!-- akan diisi dinamis via JS -->
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <button class="btn btn-primary" type="submit">Cetak PDF</button>
                </div>
            </form>
        </div>

        <script>
            document.getElementById('jenis-laporan').addEventListener('change', function() {
                const jenis = this.value;
                const filterWrapper = document.getElementById('filter-opsional');
                const filterSelect = document.getElementById('filter-by');

                filterSelect.innerHTML = '<option value="">-- Semua --</option>';
                filterWrapper.style.display = 'none';

                // Filter yang butuh user/supplier/pelanggan
                if (['pemesanans', 'obat_masuks', 'penjualans'].includes(jenis)) {
                    filterWrapper.style.display = 'block';
                    let url = '';

                    if (jenis === 'pemesanans' || jenis === 'obat_masuks') {
                        url = '/api/suppliers';
                    } else if (jenis === 'penjualans') {
                        url = '/api/pelanggans';
                    }

                    if (jenis === 'obat_masuks') {
                        url = '/api/users';
                    }

                    fetch(url)
                        .then(res => res.json())
                        .then(data => {
                            data.forEach(item => {
                                filterSelect.innerHTML +=
                                    `<option value="${item.id}">${item.nama || item.name}</option>`;
                            });
                        });
                }
            });
        </script>
    </div>
@endsection  --}}


{{--  @extends('layout.index')
@section('title-page', 'Laporan')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">E-Apotik</a></li>
    <li class="breadcrumb-item active">Laporan</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Pelaporan</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('report.export.pdf') }}" method="GET" target="_blank">
                <div class="row">
                    <div class="col-md-4">
                        <label>Jenis Laporan</label>
                        <select name="jenis" class="form-control" required id="jenis-laporan">
                            <option value="">-- Pilih Jenis --</option>
                            <option value="users">Data User</option>
                            <option value="suppliers">Data Supplier</option>
                            <option value="pelanggans">Data Pelanggan</option>
                            <option value="pemesanans">Data Pemesanan</option>
                            <option value="obat_masuks">Data Obat Masuk</option>
                            <option value="obats">Data Obat</option>
                            <option value="penjualans">Data Penjualan</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Dari Tanggal</label>
                        <input type="date" name="start" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label>Sampai Tanggal</label>
                        <input type="date" name="end" class="form-control" required>
                    </div>
                </div>

                <div class="row mt-3" id="filter-opsional" style="display: none;">
                    <div class="col-md-4">
                        <label id="filter-label">Filter Berdasarkan</label>
                        <select name="filter_id" class="form-control" id="filter-by">
                            <option value="">-- Semua --</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <button class="btn btn-primary" type="submit">Cetak PDF</button>
                </div>
            </form>
        </div>

        <script>
            document.getElementById('jenis-laporan').addEventListener('change', function() {
                const jenis = this.value;
                const filterWrapper = document.getElementById('filter-opsional');
                const filterSelect = document.getElementById('filter-by');
                const filterLabel = document.getElementById('filter-label');

                // Reset
                filterSelect.innerHTML = '<option value="">-- Semua --</option>';
                filterWrapper.style.display = 'none';
                filterLabel.innerText = 'Filter Berdasarkan';

                let url = '';
                let labelText = '';

                switch (jenis) {
                    case 'pemesanans':
                        url = '/api/suppliers';
                        labelText = 'Filter Supplier';
                        break;
                    case 'obat_masuks':
                        url = '/api/users';
                        labelText = 'Filter User';
                        break;
                    case 'penjualans':
                        url = '/api/pelanggans';
                        labelText = 'Filter Pelanggan';
                        break;
                    default:
                        url = '';
                        break;
                }

                if (url !== '') {
                    filterWrapper.style.display = 'block';
                    filterLabel.innerText = labelText;

                    fetch(url)
                        .then(res => res.json())
                        .then(data => {
                            data.forEach(item => {
                                filterSelect.innerHTML +=
                                    `<option value="${item.id}">${item.nama || item.name}</option>`;
                            });
                        })
                        .catch(err => {
                            console.error("Gagal mengambil data filter:", err);
                        });
                }
            });
        </script>
    </div>
@endsection  --}}


@extends('layout.index')
@section('title-page', 'Laporan')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">E-Apotik</a></li>
    <li class="breadcrumb-item active">Laporan</li>
@endsection

{{--  @section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Pelaporan</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('report.export.pdf') }}" method="GET" target="_blank">
                <div class="row">
                    <div class="col-md-4">
                        <label>Jenis Laporan</label>
                        <select name="jenis" class="form-control" required id="jenis-laporan">
                            <option value="">-- Pilih Jenis --</option>
                            <option value="users">Data User</option>
                            <option value="suppliers">Data Supplier</option>
                            <option value="pelanggans">Data Pelanggan</option>
                            <option value="pemesanans">Data Pemesanan</option>
                            <option value="obat_masuks">Data Obat Masuk</option>
                            <option value="obats">Data Obat</option>
                            <option value="penjualans">Data Penjualan</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Dari Tanggal</label>
                        <input type="date" name="start" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label>Sampai Tanggal</label>
                        <input type="date" name="end" class="form-control" required>
                    </div>
                </div>

                <div class="row mt-3" id="filter-opsional" style="display: none;">
                    <div class="col-md-4">
                        <label>Filter Berdasarkan</label>
                        <select name="filter_id" class="form-control" id="filter-by">
                            <option value="">-- Semua --</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <button class="btn btn-primary" type="submit">Cetak PDF</button>
                </div>
            </form>
        </div>

        <script>
            document.getElementById('jenis-laporan').addEventListener('change', function() {
                const jenis = this.value;
                const filterWrapper = document.getElementById('filter-opsional');
                const filterSelect = document.getElementById('filter-by');

                // Reset filter
                filterSelect.innerHTML = '<option value="">-- Semua --</option>';
                filterWrapper.style.display = 'none';

                // Tentukan endpoint dan field nama yang akan ditampilkan
                let url = '';
                let labelField = 'name';

                if (jenis === 'pemesanans') {
                    url = '/api/suppliers';
                    labelField = 'nama';
                } else if (jenis === 'obat_masuks') {
                    url = '/api/users';
                    labelField = 'name';
                } else if (jenis === 'penjualans') {
                    url = '/api/pelanggans';
                    labelField = 'nama';
                }

                if (url !== '') {
                    filterWrapper.style.display = 'block';
                    fetch(url)
                        .then(res => res.json())
                        .then(data => {
                            data.forEach(item => {
                                filterSelect.innerHTML +=
                                    `<option value="${item.id}">${item[labelField]}</option>`;
                            });
                        })
                        .catch(error => {
                            console.error('Gagal memuat data filter:', error);
                        });
                }
            });
        </script>
    </div>
@endsection  --}}

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Pelaporan</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('report.export.pdf') }}" method="GET" target="_blank">
                <div class="row">
                    <div class="col-md-4">
                        <label>Jenis Laporan</label>
                        <select name="jenis" class="form-control" required id="jenis-laporan">
                            <option value="">-- Pilih Jenis --</option>
                            <option value="users">Data User</option>
                            <option value="suppliers">Data Supplier</option>
                            <option value="pelanggans">Data Pelanggan</option>
                            <option value="pemesanans">Data Pemesanan</option>
                            <option value="obat_masuks">Data Obat Masuk</option>
                            <option value="obats">Data Obat</option>
                            <option value="penjualans">Data Penjualan</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Dari Tanggal</label>
                        <input type="date" name="start" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label>Sampai Tanggal</label>
                        <input type="date" name="end" class="form-control" required>
                    </div>
                </div>

                <div class="row mt-3" id="filter-opsional" style="display: none;">
                    <div class="col-md-4">
                        <label>Filter Berdasarkan</label>
                        <select name="filter_id" class="form-control" id="filter-by">
                            <option value="">-- Semua --</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <button class="btn btn-primary" type="submit">Cetak PDF</button>
                </div>
            </form>
        </div>

        {{-- Script untuk filter dinamis --}}
        <script>
            document.getElementById('jenis-laporan').addEventListener('change', function() {
                const jenis = this.value;
                const filterWrapper = document.getElementById('filter-opsional');
                const filterSelect = document.getElementById('filter-by');

                filterSelect.innerHTML = '<option value="">-- Semua --</option>';
                filterWrapper.style.display = 'none';

                let url = '';
                let label = '';

                if (jenis === 'pemesanans') {
                    url = '/api/suppliers';
                    label = 'Nama Supplier';
                } else if (jenis === 'obat_masuks') {
                    url = '/api/users';
                    label = 'Nama User';
                } else if (jenis === 'penjualans') {
                    url = '/api/pelanggans';
                    label = 'Nama Pelanggan';
                }

                if (url) {
                    filterWrapper.style.display = 'block';

                    fetch(url)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(item => {
                                filterSelect.innerHTML +=
                                    `<option value="${item.id}">${item.nama || item.name}</option>`;
                            });
                        })
                        .catch(err => {
                            console.error('Gagal memuat filter:', err);
                        });
                }
            });
        </script>
    </div>
@endsection
