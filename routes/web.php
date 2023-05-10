<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('mahasiswas', MahasiswaController::class);

Route::resource('article', ArticleController::class);

Route::get('/article/cetak/{id}', [ArticleController::class, 'cetak_pdf'])->name('cetak');

Route::get('/mahasiswas/khs/{nim}', [MahasiswaController::class, 'khs'])->name('khs');

Route::get('mahasiswa/print/{nim}', [MahasiswaController::class, 'print'])->name('print');