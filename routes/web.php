<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PenjualanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rute Publik
Route::get('/', function () {
    return redirect('/login');
});

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute yang memerlukan autentikasi
Route::middleware('auth')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    // Dashboard routes
    Route::get('/dashboard/admin', [AuthController::class, 'dashboardAdmin'])->name('dashboard.admin');
    Route::get('/dashboard/petugas', [AuthController::class, 'dashboardPetugas'])->name('dashboard.petugas');
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // Rute Pelanggan
    Route::resource('pelanggan', PelangganController::class);
    
    // Rute Produk
    Route::resource('produk', ProdukController::class);
    
    // Rute Petugas (hanya untuk administrator)
    Route::prefix('petugas')->group(function () {
        Route::get('/', [PetugasController::class, 'index'])->name('petugas.index');
        Route::get('/create', [PetugasController::class, 'create'])->name('petugas.create');
        Route::post('/', [PetugasController::class, 'store'])->name('petugas.store');
        Route::get('/{id}', [PetugasController::class, 'show'])->name('petugas.show');
        Route::get('/{id}/edit', [PetugasController::class, 'edit'])->name('petugas.edit');
        Route::put('/{id}', [PetugasController::class, 'update'])->name('petugas.update');
        Route::delete('/{id}', [PetugasController::class, 'destroy'])->name('petugas.destroy');
    });
    
    // Resource route for main penjualan operations
    Route::resource('penjualan', PenjualanController::class)->except(['destroy']);
     
    // Custom routes untuk penjualan
    Route::prefix('penjualan')->group(function () {
        Route::get('{id}/print', [PenjualanController::class, 'print'])->name('penjualan.print');
        Route::post('get-product-details', [PenjualanController::class, 'getProductDetails'])->name('penjualan.product-details');
        
        // Routes untuk penghapusan dengan konfirmasi terpisah
        Route::get('{id}/delete/confirm', [PenjualanController::class, 'confirmDelete'])->name('penjualan.delete.confirm');
        Route::post('{id}/delete', [PenjualanController::class, 'delete'])->name('penjualan.delete');
        
        // Route laporan dipisahkan dengan jelas
        Route::prefix('laporan')->group(function () {
            Route::get('petugas', [PenjualanController::class, 'laporanPenjualanPerPetugas'])->name('penjualan.laporan.petugas');
            Route::get('petugas/{id}/detail', [PenjualanController::class, 'detailPenjualanPetugas'])->name('penjualan.petugas.detail');
            
            // Route untuk cetak laporan lengkap
            Route::get('print-all', [PenjualanController::class, 'printAllSalesReport'])->name('penjualan.laporan.print-all');
        });
    });
});

// Atau jika ingin menggunakan prefix yang sudah ada:
Route::middleware('auth')->prefix('dashboard')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
});