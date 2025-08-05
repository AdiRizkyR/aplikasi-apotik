{{--  @extends('layout.index')
@section('title-page', 'Laporan Pemesanan')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">E-Apotik</a></li>
    <li class="breadcrumb-item active">Laporan Pemesanan</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Pelaporan Pemesanan</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('reportPemesanan.print') }}" method="GET" target="_blank" id="formPemesanan">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <!-- Pilihan Jenis -->
                        <div class="form-group mb-3">
                            <label for="jenis" class="form-label">Jenis Laporan</label>
                            <select name="jenis" id="jenis" class="form-control" required>
                                <option value="">-- Pilih Salah Satu --</option>
                                <option value="pemesanans">Semua Pemesanan</option>
                                <option value="pemesanans_tanggal">Pemesanan Berdasarkan Tanggal</option>
                                <option value="pemesanans_bulan">Pemesanan Berdasarkan Bulan</option>
                                <option value="pemesanans_tahun">Pemesanan Berdasarkan Tahun</option>
                            </select>
                            <!-- Input tersembunyi untuk "waktu" -->
                            <input type="hidden" name="waktu" id="waktu">
                        </div>

                        <!-- Filter Tanggal -->
                        <div class="form-group mb-3 d-none" id="filterTanggal">
                            <label for="tanggal" class="form-label">Pilih Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control">
                        </div>

                        <!-- Filter Bulan -->
                        <div class="form-group mb-3 d-none" id="filterBulan">
                            <label for="bulan" class="form-label">Pilih Bulan</label>
                            <input type="month" name="bulan" id="bulan" class="form-control">
                        </div>

                        <!-- Filter Tahun -->
                        <div class="form-group mb-3 d-none" id="filterTahun">
                            <label for="tahun" class="form-label">Pilih Tahun</label>
                            <input type="number" name="tahun" id="tahun" class="form-control"
                                placeholder="Contoh: 2024" min="2000" max="2099">
                        </div>

                        <!-- Tombol Cetak -->
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-print"></i> Cetak Laporan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Script logika filter -->
    <script>
        const jenisSelect = document.getElementById('jenis');
        const filterTanggal = document.getElementById('filterTanggal');
        const filterBulan = document.getElementById('filterBulan');
        const filterTahun = document.getElementById('filterTahun');
        const waktuInput = document.getElementById('waktu');

        jenisSelect.addEventListener('change', function() {
            const value = this.value;

            // Reset filter
            filterTanggal.classList.add('d-none');
            filterBulan.classList.add('d-none');
            filterTahun.classList.add('d-none');
            waktuInput.value = '';

            if (value === 'pemesanans_tanggal') {
                filterTanggal.classList.remove('d-none');
                waktuInput.value = 'tanggal';
            } else if (value === 'pemesanans_bulan') {
                filterBulan.classList.remove('d-none');
                waktuInput.value = 'bulan';
            } else if (value === 'pemesanans_tahun') {
                filterTahun.classList.remove('d-none');
                waktuInput.value = 'tahun';
            } else if (value === 'pemesanans') {
                waktuInput.value = 'all';
            }
        });
    </script>
@endsection  --}}

@extends('layout.index')
@section('title-page', 'Laporan Pemesanan')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">E-Apotik</a></li>
    <li class="breadcrumb-item active">Laporan Pemesanan</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Pelaporan Pemesanan</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('reportPemesanan.print') }}" method="GET" target="_blank" id="formPemesanan">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <!-- Pilihan Jenis -->
                        <div class="form-group mb-3">
                            <label for="jenis" class="form-label">Jenis Laporan</label>
                            <select name="jenis" id="jenis" class="form-control" required>
                                <option value="">-- Pilih Salah Satu --</option>
                                <option value="pemesanans">Semua Pemesanan</option>
                                <!-- <option value="pemesanans_tanggal">Pemesanan Berdasarkan Tanggal</option> -->
                                <option value="pemesanans_periode">Pemesanan Berdasarkan Periode</option>
                                <option value="pemesanans_bulan">Pemesanan Berdasarkan Bulan</option>
                                <option value="pemesanans_tahun">Pemesanan Berdasarkan Tahun</option>
                            </select>
                            <!-- Input tersembunyi untuk "waktu" -->
                            <input type="hidden" name="waktu" id="waktu">
                        </div>

                        <!-- Filter Bulan -->
                        <div class="form-group mb-3 d-none" id="filterBulan">
                            <label for="bulan" class="form-label">Pilih Bulan</label>
                            <input type="month" name="bulan" id="bulan" class="form-control">
                        </div>

                        <!-- Filter Tahun -->
                        <div class="form-group mb-3 d-none" id="filterTahun">
                            <label for="tahun" class="form-label">Pilih Tahun</label>
                            <input type="number" name="tahun" id="tahun" class="form-control"
                                placeholder="Contoh: 2024" min="2000" max="2099">
                        </div>

                        <!-- Filter Periode -->
                        <div class="form-group mb-3 d-none" id="filterPeriode">
                            <label for="tanggal_awal" class="form-label">Tanggal Awal</label>
                            <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control mb-2">
                            <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                            <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control">
                        </div>

                        <!-- Tombol Cetak -->
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-print"></i> Cetak Laporan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Script logika filter -->
    <script>
        const jenisSelect = document.getElementById('jenis');
        const filterBulan = document.getElementById('filterBulan');
        const filterTahun = document.getElementById('filterTahun');
        const filterPeriode = document.getElementById('filterPeriode');
        const waktuInput = document.getElementById('waktu');

        jenisSelect.addEventListener('change', function() {
            const value = this.value;

            // Reset semua filter
            filterBulan.classList.add('d-none');
            filterTahun.classList.add('d-none');
            filterPeriode.classList.add('d-none');
            waktuInput.value = '';

            if (value === 'pemesanans_bulan') {
                filterBulan.classList.remove('d-none');
                waktuInput.value = 'bulan';
            } else if (value === 'pemesanans_tahun') {
                filterTahun.classList.remove('d-none');
                waktuInput.value = 'tahun';
            } else if (value === 'pemesanans_periode') {
                filterPeriode.classList.remove('d-none');
                waktuInput.value = 'periode';
            } else if (value === 'pemesanans') {
                waktuInput.value = 'all';
            }
        });
    </script>
@endsection
