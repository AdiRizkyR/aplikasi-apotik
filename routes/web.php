<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\viewController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\DataObatController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PenjualanController;

Route::get('/', function () {
    return view('auth.login');
});

// start route auth
    Route::get('/login', [viewController::class, 'login'])->name('login');
    Route::get('/register', [viewController::class, 'register'])->name('register');

    // crud
        // login
            Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
            Route::post('/login', [AuthController::class, 'login']);
            Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        // end login

        // register
            Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register')->middleware('guest');
            Route::post('/register', [AuthController::class, 'register']);
        // end register

        // update password
            Route::post('/update-password', [AuthController::class, 'updatePassword'])->name('update-password')->middleware('auth');
        // end update password
    // end crud
// end route auth

// start route dashboard
    Route::get('/dashboard', [viewController::class, 'dashboard'])->name('dashboard')->middleware('auth');
// end route dashboard

// start route user
    Route::get('/user', [viewController::class, 'user'])->name('user')->middleware('auth');

    // crud
        Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
        Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    // end crud
// end route user

// start route pelanggan
    Route::get('/pelanggan', [viewController::class, 'pelanggan'])->name('pelanggan')->middleware('auth');

    // crud
        Route::post('/pelanggans', [PelangganController::class, 'store'])->name('pelanggans.store');
        Route::put('/pelanggans/{id}', [PelangganController::class, 'update'])->name('pelanggans.update');
        Route::delete('/pelanggans/{id}', [PelangganController::class, 'destroy'])->name('pelanggans.destroy');
    // end crud
// end route pelanggan

// start route supplier
    Route::get('/supplier', [viewController::class, 'supplier'])->name('supplier')->middleware('auth');

    // crud
        Route::post('/supplier', [SupplierController::class, 'store'])->name('supplier.store');
        Route::put('/supplier/{id}', [SupplierController::class, 'update'])->name('supplier.update');
        Route::delete('/supplier/{id}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
    // end crud
// end route supplier

// start route data obat
    Route::get('/dataObat', [viewController::class, 'dataObat'])->name('dataObat')->middleware('auth');

    // crud
        Route::post('/data-obat/store', [DataObatController::class, 'store'])->name('data-obat.store');
        Route::put('/data-obat/update/{id}', [DataObatController::class, 'update'])->name('data-obat.update');
        Route::delete('/data-obat/delete/{id}', [App\Http\Controllers\DataObatController::class, 'destroy'])->name('data-obat.destroy');
    // end crud
// end route data obat

// start route obat
    Route::get('/obat', [viewController::class, 'obat'])->name('obat')->middleware('auth');
// end route obat

// start route penjualan
    Route::get('/penjualan', [viewController::class, 'penjualan'])->name('penjualan')->middleware('auth');
    Route::get('/penjualans/cetak/{id}', [PenjualanController::class, 'cetak'])->name('penjualans.cetak');

    // crud
    Route::post('/penjualans', [PenjualanController::class, 'store'])->name('penjualans.store');
    // end crud
// end route penjualan

// start route pemesanan
    Route::get('/pemesanan', [viewController::class, 'pemesanan'])->name('pemesanan')->middleware('auth');
    Route::get('/pemesanan/cetak/{id}', [PemesananController::class, 'cetak'])->name('pemesanan.cetak');

    // crud
        Route::post('/pemesanans', [PemesananController::class, 'store'])->name('pemesanans.store');
        Route::delete('/pemesanan/{id}', [PemesananController::class, 'destroy'])->name('pemesanan.destroy');
    // end crud
// end route pemesanan

// start route obat masuk
    Route::get('/obatMasuk', [viewController::class, 'obatMasuk'])->name('obatMasuk')->middleware('auth');

    // crud
        // Route::put('/obat-masuk/{id}', [ObatController::class, 'update'])->name('obatMasuk.update');
        Route::put('/obat-masuk/{id}', [ObatController::class, 'update'])->name('obatMasuk.update');
        Route::delete('/obat/detail/{id}', [ObatController::class, 'deleteDetail'])->name('obat.detail.delete');
    // end crud
// end route obat masuk

// start route report
    // Route::get('/report', [viewController::class, 'report'])->name('report')->middleware('auth');
    // Route::get('/laporan/export', [viewController::class, 'exportPDF'])->name('report.export.pdf');

    // user
    Route::get('/reportUser', [viewController::class, 'reportUser'])->name('reportUser')->middleware('auth');
    Route::get('/reportUser/print', [viewController::class, 'printReportUser'])->name('reportUser.print')->middleware('auth');
    // end user

    // pemesanan
    Route::get('/reportPemesanan', [viewController::class, 'reportPemesanan'])->name('reportPemesanan')->middleware('auth');
    Route::get('/reportPemesanan/print', [viewController::class, 'reportPemesananPrint'])->name('reportPemesanan.print');
    // end pemesanan

    // obat masuk
    Route::get('/reportObatMasuk', [viewController::class, 'reportObatMasuk'])->name('reportObatMasuk')->middleware('auth');
    Route::get('/reportObatMasuk/print', [viewController::class, 'reportObatMasukPrint'])->name('reportObatMasuk.print');
    // end obat masuk

    // penjualan
    Route::get('/reportPenjualan', [viewController::class, 'reportPenjualan'])->name('reportPenjualan')->middleware('auth');
    Route::get('/reportPenjualan/print', [viewController::class, 'reportPenjualanPrint'])->name('reportPenjualan.print')->middleware('auth');
    // end penjualan

    // obat
    Route::get('/reportObat', [viewController::class, 'reportObat'])->name('reportObat')->middleware('auth');
    Route::get('/reportObat/print', [viewController::class, 'printReportObat'])->name('reportObat.print')->middleware('auth');
    // end obat
// end route report
