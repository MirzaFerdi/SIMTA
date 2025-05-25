<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BimbinganController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengajuanJudulController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\SemproController;
use App\Http\Controllers\TugasAkhirController;
use App\Models\Bimbingan;

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
    if(Auth::check()){
        return redirect()->route('dashboard');
    }
    return view('auth.login');
})->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'index'])->name('dashboard');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::get('/pengajuan', [PengajuanJudulController::class, 'index'])->name('pengajuan');
    Route::get('/penjadwalan', [JadwalController::class, 'index'])->name('penjadwalan');
    Route::get('/seminar-proposal', [SemproController::class, 'index'])->name('sempro');
    Route::get('/tugas-akhir', [TugasAkhirController::class, 'index'])->name('tugas-akhir');
    Route::get('/bimbingan', [BimbinganController::class, 'index'])->name('bimbingan');

    Route::middleware(['role:1'])->group(function () {
        Route::get('/user', [UserController::class, 'index'])->name('user');
        Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
        Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/user/update/{user}', [UserController::class, 'update'])->name('user.update');
        Route::post('/user/delete/{user}', [UserController::class, 'destroy'])->name('user.delete');
    });

    Route::middleware(['role:3'])->group(function () {
        Route::post('/pengajuan/store', [PengajuanJudulController::class, 'store'])->name('pengajuan.store');
        Route::put('/pengajuan/{pengajuanJudul}', [PengajuanJudulController::class, 'update'])->name('pengajuan.update');
        Route::post('/bimbingan/store', [BimbinganController::class, 'store'])->name('bimbingan.store');
        Route::put('/bimbingan/{bimbingan}', [BimbinganController::class, 'update'])->name('bimbingan.update');
        Route::post('/bimbingan/delete/{bimbingan}', [BimbinganController::class, 'destroy'])->name('bimbingan.delete');

    });
});
Route::get('/403', function () {
    return view('errors.403');
})->name('403');
