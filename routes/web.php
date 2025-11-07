<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\YayasanController;
use App\Http\Controllers\Admin\DashboardController; // Pastikan ini di-import

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ===================================================================
// RUTE PUBLIK (Bisa diakses siapa saja)
// ===================================================================
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/cek-pendaftaran', [PublicController::class, 'cekPendaftaran'])->name('pendaftaran.cek');


// ===================================================================
// RUTE OTENTIKASI (Hanya untuk Tamu / Guest)
// ===================================================================
Route::middleware(['guest'])->group(function () {
  Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
  Route::post('/login', [AuthController::class, 'login']);
  Route::get('/pendaftaran', [AuthController::class, 'showRegistrationForm'])->name('pendaftaran');
  Route::post('/pendaftaran', [AuthController::class, 'register']);
});

// ===================================================================
// RUTE UMUM UNTUK YANG SUDAH LOGIN (Auth)
// ===================================================================
Route::middleware(['auth'])->group(function () {
  Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// ===================================================================
// RUTE KHUSUS USER (Siswa PPDB)
// ===================================================================
Route::middleware(['auth', 'user'])->prefix('user')->name('user.')->group(function () {
  Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
  Route::get('/biodata', [UserDashboardController::class, 'showBiodataForm'])->name('biodata');
  Route::post('/biodata', [UserDashboardController::class, 'store'])->name('biodata.store');
  Route::get('/pembayaran', [UserDashboardController::class, 'showPembayaranForm'])->name('pembayaran');
  Route::post('/pembayaran', [UserDashboardController::class, 'storePembayaran'])->name('pembayaran.store');
});
// ===================================================================
// RUTE KHUSUS ADMIN
// ===================================================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
  Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
  Route::get('/daftar_murid', [AdminDashboardController::class, 'daftar_murid'])->name('daftar_murid');
  Route::get('/verif-pembayaran', [AdminDashboardController::class, 'showListPembayaran'])->name('listPembayaran');
  Route::post('/verif-pembayaran/{pembayaran}/approve', [AdminDashboardController::class, 'updatePembayaran'])
    ->name('listPembayaran.approve');
  Route::post('/verif-pembayaran/{pembayaran}/reject', [AdminDashboardController::class, 'rejectPembayaran'])
    ->name('listPembayaran.reject');
  Route::get('/verifikasi-berkas', [AdminDashboardController::class, 'show_verifikasi_berkas'])
    ->name('verifikasi_berkas.index');
  Route::post('/verifikasi-berkas/{murid}/approve', [AdminDashboardController::class, 'approveVerifikasi'])
    ->name('verifikasi.approve');
  Route::post('/verifikasi-berkas/{murid}/revise', [AdminDashboardController::class, 'reviseVerifikasi'])
    ->name('verifikasi.revise');
  Route::get('/laporan-pendaftaran', [AdminDashboardController::class, 'showLaporanPendaftaran'])
    ->name('laporan.pendaftaran');
});

// ===================================================================
// RUTE KHUSUS KETUA YAYASAN
// ===================================================================
Route::middleware(['auth', 'ketua'])->prefix('ketua')->name('ketua.')->group(function () {
  Route::get('/dashboard', [YayasanController::class, 'index'])->name('dashboard');
  Route::get('/laporan-pendaftaran', [YayasanController::class, 'showLaporanPendaftaran'])
    ->name('laporan.pendaftaran');
});
