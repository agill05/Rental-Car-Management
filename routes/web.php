<?php

use Illuminate\Support\Facades\Route;
// Jangan lupa import controller di paling atas!
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserRentalController;
use App\Http\Controllers\MerekController;
use App\Http\Controllers\JenisMobilController;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\SupirController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Middleware\IsAdmin;

// --- 1. HALAMAN PUBLIK & AUTH ---

Route::get('/', [UserRentalController::class, 'index'])->name('home');

// Route Auth (Login, Register, Logout)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// --- 2. HALAMAN USER (PELANGGAN) ---
Route::middleware(['auth'])->group(function () {
    Route::get('/my-rentals', [UserRentalController::class, 'myRentals'])->name('my.rentals');
    Route::get('/rent/{mobil}', [UserRentalController::class, 'createRental'])->name('rental.create');
    Route::post('/rent', [UserRentalController::class, 'storeRental'])->name('rental.store');
    Route::post('/return-request/{peminjaman}', [UserRentalController::class, 'requestReturn'])->name('return.request');
    Route::get('/user/kwitansi-penyewaan/{peminjaman}', [UserRentalController::class, 'tampilkanKwitansi'])->name('user.kwitansi.penyewaan');
});


// --- 3. HALAMAN ADMIN ---
Route::middleware(['auth', IsAdmin::class])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('mobils', MobilController::class);
    Route::resource('jenis_mobils', JenisMobilController::class);
    Route::resource('mereks', MerekController::class);
    Route::resource('supirs', SupirController::class);
    Route::resource('pelanggans', PelangganController::class);
    Route::resource('peminjaman', PeminjamanController::class);
    Route::post('peminjaman/{peminjaman}/approve', [PeminjamanController::class, 'approve'])->name('peminjaman.approve');
    Route::post('peminjaman/{peminjaman}/approve-return', [PeminjamanController::class, 'approveReturn'])->name('peminjaman.approve.return');
    Route::resource('pengembalian', PengembalianController::class);
});