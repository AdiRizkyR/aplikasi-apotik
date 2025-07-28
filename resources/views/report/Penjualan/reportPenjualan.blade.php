@extends('layout.index')
@section('title-page', 'Laporan Penjualan')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">E-Apotik</a></li>
    <li class="breadcrumb-item active">Laporan Penjualan</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Pelaporan Penjualan</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('reportPenjualan.print') }}" method="GET" target="_blank" id="formPenjualan">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <!-- Pilihan Jenis -->
                        <div class="form-group mb-3">
                            <label for="jenis" class="form-label">Jenis Laporan</label>
                            <select name="jenis" id="jenis" class="form-control" required>
                                <option value="">-- Pilih Salah Satu --</option>
                                <option value="penjualans">Semua Penjualan</option>
                                <option value="penjualans_tanggal">Penjualan Berdasarkan Tanggal</option>
                                <option value="penjualans_bulan">Penjualan Berdasarkan Bulan</option>
                                <option value="penjualans_tahun">Penjualan Berdasarkan Tahun</option>
                            </select>
                            <input type="hidden" name="waktu" id="waktu">
                        </div>

                        <div class="form-group mb-3 d-none" id="filterTanggal">
                            <label for="tanggal" class="form-label">Pilih Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control">
                        </div>

                        <div class="form-group mb-3 d-none" id="filterBulan">
                            <label for="bulan" class="form-label">Pilih Bulan</label>
                            <input type="month" name="bulan" id="bulan" class="form-control">
                        </div>

                        <div class="form-group mb-3 d-none" id="filterTahun">
                            <label for="tahun" class="form-label">Pilih Tahun</label>
                            <input type="number" name="tahun" id="tahun" class="form-control"
                                placeholder="Contoh: 2024" min="2000" max="2099">
                        </div>

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

    <script>
        const jenisSelect = document.getElementById('jenis');
        const filterTanggal = document.getElementById('filterTanggal');
        const filterBulan = document.getElementById('filterBulan');
        const filterTahun = document.getElementById('filterTahun');
        const waktuInput = document.getElementById('waktu');

        jenisSelect.addEventListener('change', function() {
            filterTanggal.classList.add('d-none');
            filterBulan.classList.add('d-none');
            filterTahun.classList.add('d-none');
            waktuInput.value = '';

            if (this.value === 'penjualans_tanggal') {
                filterTanggal.classList.remove('d-none');
                waktuInput.value = 'tanggal';
            } else if (this.value === 'penjualans_bulan') {
                filterBulan.classList.remove('d-none');
                waktuInput.value = 'bulan';
            } else if (this.value === 'penjualans_tahun') {
                filterTahun.classList.remove('d-none');
                waktuInput.value = 'tahun';
            } else if (this.value === 'penjualans') {
                waktuInput.value = 'all';
            }
        });
    </script>
@endsection
