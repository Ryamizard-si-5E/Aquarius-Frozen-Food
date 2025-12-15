<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PelangganVerificationController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PelangganAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\WhatsappController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\OngkirController;
// =======================
// Halaman utama
// =======================
Route::get('/', [LandingController::class, 'awal'])->name('awal');
Route::get('/produk', [LandingController::class, 'index'])->name('index');

// Dashboard (setelah login)
Route::get('/awal2', [LandingController::class, 'awal2'])
    ->name('awal2')
    ->middleware('auth:pelanggan');
Route::get('/dashboard', [LandingController::class, 'dashboard'])->name('dashboard');

// =======================
// Auth Pelanggan
// =======================
Route::get('/login', [PelangganAuthController::class, 'showLoginForm'])->name('login'); // Default Laravel name
Route::post('/login', [PelangganAuthController::class, 'login'])->name('pelanggan.login');
Route::get('/register', [PelangganAuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [PelangganAuthController::class, 'register'])->name('pelanggan.register');

// =======================
// Auth Admin
// =======================
Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');
Route::post('/simpan-produk', [AdminController::class, 'simpanProduk'])->name('admin.simpanProduk');
Route::post('/update-stok/{id_barang}', [AdminController::class, 'updateStok'])->name('admin.updateStok');
Route::delete('/hapus-produk/{id_barang}', [AdminController::class, 'hapusProduk'])->name('admin.hapusProduk');
Route::middleware(['auth:admin'])->group(function () {
Route::get('/admin', [LandingController::class, 'admin'])->name('admin.dashboard');
});
Route::get('/admin/transaksi', [TransaksiController::class, 'index'])->name('admin.transaksi');
Route::post('/admin/transaksi/terima/{id}', [TransaksiController::class, 'terima'])->name('admin.transaksi.terima');
Route::post('/admin/transaksi/tolak/{id}', [TransaksiController::class, 'tolak'])->name('admin.transaksi.tolak');
Route::put('/admin/transaksi/{id}/pengiriman/{status}', 
    [TransaksiController::class, 'updatePengiriman']
)->name('admin.transaksi.updatePengiriman');



Route::get('/keranjang', [KeranjangController::class, 'keranjang'])->name('keranjang.index');
Route::post('/keranjang/tambah/{id}', [KeranjangController::class, 'add'])->name('keranjang.tambah');
Route::post('/keranjang/hapus/{id}', [KeranjangController::class, 'destroy'])->name('keranjang.hapus');
Route::post('/keranjang/checkout', [KeranjangController::class, 'checkout'])->name('keranjang.checkout');


//WA
Route::get('/wa', [WhatsappController::class, 'user'])->name('wa.form');
Route::post('/wa/send', [WhatsappController::class, 'send'])->name('wa.send');

//Hapus Pelanggan
Route::get('/datauser', [AdminController::class, 'User'])->name('pelanggan.index');
Route::delete('/datauser/{id_pelanggan}', [AdminController::class, 'destroy'])->name('pelanggan.destroy');

//profil
Route::middleware('auth:pelanggan')->group(function () {
    Route::get('/profil', [PelangganController::class, 'profil'])->name('profil');
    Route::get('/profil/edit', [PelangganController::class, 'edit'])->name('profil.edit');
    Route::post('/profil/update', [PelangganController::class, 'update'])->name('profil.update');
});

//Notifikasi
// Menampilkan daftar notifikasi untuk pelanggan yang sedang login
Route::get('/notifikasi', [NotifikasiController::class, 'notifikasi'])
    ->name('notifikasi');

// Menyimpan notifikasi baru (bisa dipanggil oleh admin / sistem)
Route::post('/notifikasi', [NotifikasiController::class, 'store'])
    ->name('notifikasi.store');

//Halaman Verfikasi User
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/verify-pelanggan', [PelangganVerificationController::class, 'index'])->name('admin.verify.pelanggan');
    Route::post('/admin/verify-pelanggan/{pelanggan}/approve', [PelangganVerificationController::class, 'approve'])->name('admin.verify.pelanggan.approve');
    Route::post('/admin/verify-pelanggan/{pelanggan}/reject', [PelangganVerificationController::class, 'reject'])->name('admin.verify.pelanggan.reject');

});

//Laporan Penjualan Admin
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/laporan-penjualan', [LaporanController::class, 'index'])->name('admin.laporan.penjualan');
    Route::get('/laporan/download', [LaporanController::class, 'downloadLaporan'])->name('laporan.download');
});

Route::get('/tes-email', function () {
    try {
        Mail::raw('Halo, ini percobaan email dari Laravel 🚀', function ($message) {
            $message->to('ryamizardfyant@gmail.com')
                    ->subject('Tes Email dari Laravel');
        });
        return '✅ Email berhasil dikirim!';
    } catch (\Exception $e) {
        return '❌ Gagal: ' . $e->getMessage();
    }
});

//ongkir
Route::post('/hitung-jarak', [KeranjangController::class, 'hitungJarak'])->name('hitung.jarak');