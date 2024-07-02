<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\KelurahanController;
use App\Http\Controllers\PerankinganController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\TahunController;
use App\Models\Data;
use App\Models\Kelurahan;

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

Route::get('/dashboard', function () {
    return view('admin/admin_crud/dashboard');
});

Route::resource('perankingan', PerankinganController::class);

Route::get('/sesi', [SessionController::class, 'index']);
Route::post('/sesi/login', [SessionController::class, 'login']);
Route::get('logout', [SessionController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'ceklevel:admin'])->group(function() {
    Route::resource('kriteria', KriteriaController::class);
    Route::resource('kelurahan', KelurahanController::class);
    Route::resource('data', DataController::class);
    Route::resource('tahuns', TahunController::class);
    Route::get('/kelurahan/create', [KelurahanController::class, 'create'])->name('kelurahan.create');
    Route::get('/kelurahan/{tahun_id}', [KelurahanController::class, 'index'])->name('kelurahan.index');
    Route::get('/kelurahan/{id}/data', [DataController::class, 'index'])->name('data.index');
    Route::get('/data/upload', [DataController::class, 'showUploadForm'])->name('data.upload.form');
    Route::post('/data/uploaded', [DataController::class, 'dataimportexcel'])->name('data.import');
    Route::get('/hitungumkm/{id}', [DataController::class, 'hitung'])->name('data.hitung');
    Route::get('/download-template', function () {
        $file = storage_path('app/public/template.xlsx');
        return response()->download($file);
    })->name('download.template');
    
});

Route::get('/pilihkelurahan', [PerankinganController::class, 'pilihkelurahan']);
Route::get('/hasil/{id}', [DataController::class, 'hasil'])->name('data.hasil');