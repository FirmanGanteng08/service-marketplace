<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController; // Tambahkan ini
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;


// Grup Route Khusus Admin
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class);
});
// 1. Ubah Route '/' dari function biasa menjadi Controller
Route::get('/', [ServiceController::class, 'index'])->name('home');
// Rute untuk melihat detail jasa
Route::get('/jasa/{id}', [App\Http\Controllers\ServiceController::class, 'show'])->name('service.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Rute untuk proses pemesanan (Checkout)
    Route::get('/checkout/{service}/{package}', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/{service}/{package}', [OrderController::class, 'process'])->name('checkout.process');
    // Rute Saldo & Top Up
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index');
    Route::post('/wallet/topup', [WalletController::class, 'topup'])->name('wallet.topup');
});

require __DIR__.'/auth.php';