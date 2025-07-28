{{--  @extends('layout.index')
@section('title-page', 'Dashboard gaes')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">E-Apotik</a></li>
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Ini kepalanya</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <h1>Selamat Datang</h1>
        </div>
        <!-- /.card-body -->
    </div>
@endsection  --}}


@extends('layout.index')
@section('title-page', 'Dashboard')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">E-Apotik</a></li>
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="mb-4">
            <h3>Selamat datang, <strong>{{ Auth::user()->name }}</strong> di <strong>Website E-Apotik</strong></h3>
            <p class="text-muted">Berikut ringkasan data sistem apotek Anda.</p>
        </div>

        <div class="row">
            <!-- Jumlah User -->
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card bg-info text-white shadow">
                    <div class="card-body">
                        <h5>Total User</h5>
                        <h3>{{ $userCount }}</h3>
                        <i class="fas fa-user fa-2x float-right"></i>
                    </div>
                </div>
            </div>

            <!-- Jumlah Supplier -->
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card bg-success text-white shadow">
                    <div class="card-body">
                        <h5>Total Supplier</h5>
                        <h3>{{ $supplierCount }}</h3>
                        <i class="fas fa-truck fa-2x float-right"></i>
                    </div>
                </div>
            </div>

            <!-- Jumlah Pelanggan -->
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card bg-warning text-dark shadow">
                    <div class="card-body">
                        <h5>Total Pelanggan</h5>
                        <h3>{{ $pelangganCount }}</h3>
                        <i class="fas fa-users fa-2x float-right"></i>
                    </div>
                </div>
            </div>

            <!-- Jumlah Data Obat -->
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card bg-danger text-white shadow">
                    <div class="card-body">
                        <h5>Jenis Obat</h5>
                        <h3>{{ $obatCount }}</h3>
                        <i class="fas fa-capsules fa-2x float-right"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Total Stok -->
            <div class="col-md-4 col-sm-6 mb-3">
                <div class="card bg-primary text-white shadow">
                    <div class="card-body">
                        <h5>Total Stok Obat</h5>
                        <h3>{{ $stokTotal }}</h3>
                        <i class="fas fa-boxes fa-2x float-right"></i>
                    </div>
                </div>
            </div>

            <!-- Total Penjualan -->
            <div class="col-md-4 col-sm-6 mb-3">
                <div class="card bg-secondary text-white shadow">
                    <div class="card-body">
                        <h5>Total Penjualan</h5>
                        <h3>{{ $penjualanCount }}</h3>
                        <i class="fas fa-shopping-cart fa-2x float-right"></i>
                    </div>
                </div>
            </div>

            <!-- Total Pemesanan -->
            <div class="col-md-4 col-sm-6 mb-3">
                <div class="card bg-dark text-white shadow">
                    <div class="card-body">
                        <h5>Total Pemesanan</h5>
                        <h3>{{ $pemesananCount }}</h3>
                        <i class="fas fa-file-invoice fa-2x float-right"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
