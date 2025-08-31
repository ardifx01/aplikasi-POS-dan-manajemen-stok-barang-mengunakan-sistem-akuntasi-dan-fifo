<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\CoaController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ReturnBarangController;
use App\Http\Controllers\KartuStokController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\JurnalumumController;
use App\Http\Controllers\LaporanPenjualanController;
use App\Http\Controllers\BukuBesarController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return redirect('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
Route::get('/kalender', function () {
    return view('kalender'); // ini nanti file: resources/views/kalender.blade.php
})->name('kalender');

Route::get('/notifikasi', [App\Http\Controllers\NotifikasiController::class, 'index'])->name('notifikasi');
Route::get('/notifikasi', [DashboardController::class, 'getNotifikasi'])->name('notifikasi');

Route::get('auth/{provider}', [SocialAuthController::class, 'redirect']);
Route::get('auth/{provider}/callback', [SocialAuthController::class, 'callback']);

Route::get('/dashboardbootstrap', [DashboardController::class, 'index'])->name('dashboardbootstrap');

// Kartu stok (boleh tetap)
Route::get('/produk/kartustok', [KartuStokController::class, 'index'])->name('produk.kartustok');

// route ke master data produk

Route::resource('produk', ProdukController::class);

// Kalau kamu masih butuh destroy manual (tidak pakai method DELETE via form):
Route::get('/produk/destroy/{id}', [ProdukController::class, 'destroy'])->middleware(['auth']);

// route ke master data coa
Route::resource('/coa', CoaController::class)->middleware(['auth']);
Route::get('/coa/destroy/{id}', [App\Http\Controllers\CoaController::class,'destroy'])->middleware(['auth']);

// route ke master data supplier
Route::resource('/supplier', SupplierController::class)->middleware(['auth']);
Route::get('/supplier/destroy/{id}', [App\Http\Controllers\SupplierController::class,'destroy'])->middleware(['auth']);


Route::get('/pembelian', [PembelianController::class, 'index'])->name('pembelian.index'); // tampilan utama (view.blade.php)
Route::get('/pembelian/create', [PembelianController::class, 'create'])->name('pembelian.create'); // form tambah
Route::post('/pembelian', [PembelianController::class, 'store'])->name('pembelian.store'); // simpan data
Route::get('/pembelian/{id}/edit', [PembelianController::class, 'edit'])->name('pembelian.edit'); // form edit
Route::put('/pembelian/{id}', [PembelianController::class, 'update'])->name('pembelian.update'); // update data
Route::delete('/pembelian/{id}', [PembelianController::class, 'destroy'])->name('pembelian.destroy'); // hapus data

// Route for the sales index page
Route::resource('/penjualan', PenjualanController::class)->middleware(['auth']);
Route::get('/penjualan/destroy/{id}', [App\Http\Controllers\PenjualanController::class,'destroy'])->middleware(['auth']);

// Jika Anda menggunakan rute createMarketplace, tambahkan juga:
Route::get('/penjualan/create-marketplace', [PenjualanController::class, 'createMarketplace'])->name('penjualan.createMarketplace');

// Rute untuk melihat detail penjualan (setelah checkout)
Route::get('/penjualan/view/{kode_penjualan}', [PenjualanController::class, 'view'])->name('penjualan.view');
// ...
Route::post('/penjualan/keranjang/update', [PenjualanController::class, 'updateCartQuantity'])->name('penjualan.keranjang.update');
// ...
// ...

Route::resource('returnbarang', ReturnBarangController::class);
Route::get('/returnbarang', [ReturnBarangController::class, 'index'])->name('returnbarang.index');
Route::get('/returnbarang/create', [ReturnBarangController::class, 'create'])->name('returnbarang.create');
Route::post('/returnbarang', [ReturnBarangController::class, 'store'])->name('returnbarang.store');
Route::get('/returnbarang/{id}/edit', [ReturnBarangController::class, 'edit'])->name('returnbarang.edit');
Route::get('/returnbarang/{id}', [ReturnBarangController::class, 'show'])->name('returnbarang.show');
Route::put('/returnbarang/{id}', [ReturnBarangController::class, 'update'])->name('returnbarang.update');
Route::delete('/returnbarang/{id}', [ReturnBarangController::class, 'destroy'])->name('returnbarang.destroy');

Route::prefix('jurnalumum')->name('jurnalumum.')->group(function () {
    Route::get('/', [JurnalUmumController::class, 'index'])->name('index');
    Route::get('/create', [JurnalUmumController::class, 'create'])->name('create');
    Route::post('/store', [JurnalUmumController::class, 'store'])->name('store');
});


Route::get('/laporan/penjualanbulanan', [LaporanPenjualanController::class, 'index']);
Route::get('/laporan/bukubesar', [BukuBesarController::class, 'index'])->name('laporan.bukubesar');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
