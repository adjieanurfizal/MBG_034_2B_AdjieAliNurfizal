<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\PermintaanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    // Arahkan ke halaman yang sesuai berdasarkan role setelah login
    if (auth()->user()->role == 'gudang') {
        return redirect()->route('bahan-baku.index');
    } elseif (auth()->user()->role == 'dapur') {
        return redirect()->route('permintaan.create');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Grup Rute KHUSUS UNTUK ROLE GUDANG
Route::middleware(['auth', 'cekrole:gudang'])->group(function () {
    Route::resource('bahan-baku', BahanBakuController::class);
});

// Grup Rute KHUSUS UNTUK ROLE DAPUR
Route::middleware(['auth', 'cekrole:dapur'])->group(function () {
    Route::resource('permintaan', PermintaanController::class);
});

require __DIR__.'/auth.php';
