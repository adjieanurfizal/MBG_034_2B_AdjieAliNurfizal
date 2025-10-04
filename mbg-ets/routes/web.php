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

// Rute ROLE GUDANG
Route::middleware(['auth', 'cekrole:gudang'])->group(function () {
    Route::resource('bahan-baku', BahanBakuController::class);
    Route::get('/persetujuan', [PersetujuanController::class, 'index'])->name('persetujuan.index');
    Route::get('/persetujuan/{id}', [PersetujuanController::class, 'show'])->name('persetujuan.show');
    Route::post('/persetujuan/{id}', [PersetujuanController::class, 'proses'])->name('persetujuan.proses');
});

// Rute ROLE DAPUR
Route::middleware(['auth', 'cekrole:dapur'])->group(function () {
    Route::resource('permintaan', PermintaanController::class);
});

require __DIR__.'/auth.php';
