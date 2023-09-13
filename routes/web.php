<?php

use App\Http\Controllers\DataController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\SoalController;
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

Route::get('/', [LoginController::class, 'viewLogin'])->middleware('check');
Route::post('/', [LoginController::class, 'login']);
Route::get('/logout', function () {
    session()->flush();
    return redirect('/');
});

// ===============================================================================================
// Guru
// ===============================================================================================
Route::middleware(['check:guru'])->group(function () {
    // ===============================================================================================
    // zone view
    // ===============================================================================================
    Route::get('/guru', [DataController::class, 'dashboard']);
    Route::get('/guru/data/data-guru', [DataController::class, 'viewDataGuru']);
    Route::get('/guru/data/data-siswa', [DataController::class, 'viewDataSiswa']);
    Route::get('/guru/data/data-kelas', [DataController::class, 'viewDataKelas']);
    Route::get('/guru/data/data-dudi', [DataController::class, 'viewDataDudi']);
    Route::get('/guru/soal/{jenis}', [SoalController::class, 'viewSoal']);
    Route::get('/guru/soal/edit/{id}', [SoalController::class, 'viewEditSoal']);
    Route::get('/guru/soal/ukk/edit/{id}', [SoalController::class, 'viewEditSoalUkk']);

    // ===============================================================================================
    // zone add
    // ===============================================================================================
    Route::post('/guru/soal/{jenis}', [SoalController::class, 'addSoal']);
    Route::post('/guru/soal/add/butir-pilihan/{id}', [SoalController::class, 'addButirPilihan']);
    Route::post('/guru/soal/add/butir-uraian/{id}', [SoalController::class, 'addButirUraian']);
    Route::post('/guru/soal/ukk/add', [SoalController::class, 'addSoalUkk']);

    // ===============================================================================================
    // zone delete
    // ===============================================================================================
    Route::get('/guru/soal/delete/{id}', [SoalController::class, 'deleteSoal']);
    Route::get('/guru/soal/edit/delete/{id}', [SoalController::class, 'deleteButirPilihan']);
    Route::get('/guru/soal/edit/delete/uraian/{id}', [SoalController::class, 'deleteButirUraian']);
    Route::get('/guru/soal/ukk/delete/{id}', [SoalController::class, 'deleteSoalUkk']);

    // ===============================================================================================
    // zone edit
    // ===============================================================================================
    Route::post('/guru/soal/edit/{id}', [SoalController::class, 'editSoal']);
    Route::post('/guru/soal/edit/butir-pilihan/{id}', [SoalController::class, 'editButirPilihan']);
    Route::post('/guru/soal/edit/butir-uraian/{id}', [SoalController::class, 'editButirUraian']);
    Route::post('/guru/soal/ukk/edit/{id}', [SoalController::class, 'editSoalUkk']);
});

// ===============================================================================================
// Siswa
// ===============================================================================================
Route::middleware(['check:siswa'])->group(function () {
    // ===============================================================================================
    // zone view
    // ===============================================================================================
    Route::get('/siswa', [SiswaController::class, 'index']);

    Route::get('/siswa/soal/{jenis}', [SiswaController::class, 'viewSoal']);

    // ===============================================================================================
    // zone validasi
    // ===============================================================================================
    Route::post('/siswa/token/submit/{id}', [SiswaController::class, 'submitToken']);
});

// ===============================================================================================
// Ujian
// ===============================================================================================
Route::get('/siswa/kerjakan/{jenis}/{id}', [SiswaController::class, 'viewKerjakan'])->middleware('check:ujian');

// ===============================================================================================
// Hanya Admin !!!
// ===============================================================================================
Route::middleware(['admin'])->group(function () {
    // ===============================================================================================
    // zone add
    // ===============================================================================================
    Route::post('/guru/data/data-guru', [DataController::class, 'addDataGuru']);
    Route::post('/guru/data/data-kelas', [DataController::class, 'addDataKelas']);
    Route::post('/guru/data/data-siswa', [DataController::class, 'addDataSiswa']);
    Route::post('/guru/data/data-dudi', [DataController::class, 'addDataDudi']);

    // ===============================================================================================
    // zone delete
    // ===============================================================================================
    Route::get('/guru/data/data-guru/delete/{id}', [DataController::class, 'deleteDataGuru']);
    Route::get('/guru/data/data-kelas/delete/{id}', [DataController::class, 'deleteDataKelas']);
    Route::get('/guru/data/data-siswa/delete/{id}', [DataController::class, 'deleteDataSiswa']);
    Route::get('/guru/data/data-dudi/delete/{id}', [DataController::class, 'deleteDataDudi']);

    // ===============================================================================================
    // zone edit
    // ===============================================================================================
    Route::post('/guru/data/data-guru/edit/{nip}', [DataController::class, 'editDataGuru']);
    Route::post('/guru/data/data-siswa/edit/{id}', [DataController::class, 'editDataSiswa']);
    Route::post('/guru/data/data-dudi/edit/{id}', [DataController::class, 'editDataDudi']);
});


Route::get('/debug', function () {
    dd(session()->all());
});
