<?php

use App\Http\Controllers\Api\JabatanController;
use App\Http\Controllers\Api\PegawaiController;
use App\Http\Controllers\Api\PegawaiJabatanController;
use App\Http\Controllers\Api\PegawaiPenugasanController;
use App\Http\Controllers\Api\PenugasanController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/logout', [UserController::class, 'logout']);
    
});

// Public Routes User
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::delete('/delete_user/{id}', [UserController::class, 'destroy']);
Route::put('/update_user/{id}', [UserController::class, 'update']);

// Public Routes Jabatan
Route::post('jabatan_add', [JabatanController::class, 'store']);
Route::get('jabatan', [JabatanController::class, 'index']);
Route::get('jabatan/{id}', [JabatanController::class, 'show']);
Route::put('jabatan/{id}', [JabatanController::class, 'update']);
Route::delete('jabatan/{id}', [JabatanController::class, 'destroy']);
Route::get('jabatanOption', [JabatanController::class, 'getJabatan']);

// Public Routes Penugasan
Route::get('penugasan', [PenugasanController::class, 'index']);
Route::post('penugasan_add', [PenugasanController::class, 'store']);
Route::get('penugasan/{id}', [PenugasanController::class, 'show']);
Route::put('penugasan/{id}', [PenugasanController::class, 'update']);
Route::delete('penugasan/{id}', [PenugasanController::class, 'destroy']);
Route::get('penugasanOption', [PenugasanController::class, 'getPenugasan']);

// Public Routes Pegawai
Route::get('pegawai', [PegawaiController::class, 'index']);
Route::post('pegawai_add', [PegawaiController::class, 'store']);
Route::get('pegawai/{id}', [PegawaiController::class, 'show']);
Route::get('pegawai_all', [PegawaiController::class, 'getAllPegawaiData']);
Route::put('pegawai/{id}', [PegawaiController::class, 'update']);
Route::delete('pegawai/{id}', [PegawaiController::class, 'destroy']);

// Public Routes Pegawai Jabatan
Route::get('pegawai_jabatan', [PegawaiJabatanController::class, 'index']);
Route::post('pegawai_jabatan_add', [PegawaiJabatanController::class, 'store']);
Route::get('pegawai_jabatan/{id}', [PegawaiJabatanController::class, 'show']);
Route::put('pegawai_jabatan/{id}', [PegawaiJabatanController::class, 'update']);
Route::delete('pegawai_jabatan/{id}', [PegawaiJabatanController::class, 'destroy']);


// Public Routes Pegawai Penugasan
Route::get('pegawai_penugasan', [PegawaiPenugasanController::class, 'index']);
Route::post('pegawai_penugasan_add', [PegawaiPenugasanController::class, 'store']);
Route::get('pegawai_penugasan/{id}', [PegawaiPenugasanController::class, 'show']);
Route::put('pegawai_penugasan/{id}', [PegawaiPenugasanController::class, 'update']);
Route::delete('pegawai_penugasan/{id}', [PegawaiPenugasanController::class, 'destroy']);


