@extends('layout.index')
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
@endsection
