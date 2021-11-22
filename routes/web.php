<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IndexKriteriaController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KategoriHasilController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\PenilaianDetailController;
use App\Http\Controllers\PenilaianTimController;
use App\Http\Controllers\TimController;
use App\Http\Controllers\TimDetailController;
use App\Http\Controllers\TimUnitController;
use App\Http\Controllers\UnitDetailController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::resource('user', UserController::class);
    Route::resource('tim', TimController::class);
    Route::resource('karyawan', KaryawanController::class);
    Route::resource('kategoriHasil', KategoriHasilController::class);
    Route::resource('kriteria', KriteriaController::class);
    Route::resource('area', AreaController::class);
    Route::resource('nilai', NilaiController::class);
    Route::resource('unitDetail', UnitDetailController::class);
    Route::resource('timDetail', TimDetailController::class);
    Route::resource('timUnit', TimUnitController::class);
    Route::resource('penilaian', PenilaianController::class);
    Route::resource('penilaianDetail', PenilaianDetailController::class);
    Route::resource('penilaianTim', PenilaianTimController::class);
    Route::resource('indexKriteria', IndexKriteriaController::class);
    Route::get('kriteria/{id}/showKriteria', [KriteriaController::class, 'showKriteria'])->name('kriteria.showKriteria');
    Route::put('indexKriteria/multiUpdate/{id}', [IndexKriteriaController::class, 'multiUpdate'])->name('multiUpdate');
});