@extends('layout.index')
@section('title-page', 'Laporan User')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">E-Apotik</a></li>
    <li class="breadcrumb-item active">Laporan User</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Pelaporan User</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('reportUser.print') }}" method="GET" target="_blank">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="jenis" class="form-label">Pilih Tabel Data</label>
                            <select name="jenis" id="jenis" class="form-control" required>
                                <option value="">-- Pilih Salah Satu --</option>
                                <option value="users">User</option>
                                <option value="suppliers">Supplier</option>
                                <option value="pelanggans">Pelanggan</option>
                            </select>
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
@endsection
