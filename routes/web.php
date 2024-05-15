<?php
use App\Http\Controllers\BarangController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/barang/{id}/edit', [BarangController::class, 'edit'])->name('barang.edit');
Route::put('/barang/{id}', [BarangController::class, 'update'])->name('barang.update');
Route::post('/barang/tambah', [BarangController::class, 'store']);

Route::get('/databarang', [BarangController::class,'tabelbarang'])->name('databarang');
Route::get('/index', [HomeController::class, 'index'])->name('index');
Route::get('/jadwal', [HomeController::class, 'calendar']);
Route::get('/login', [LoginController::class, 'login']);
Route::get('/gantipassword', [HomeController::class, 'gantipassword']);
Route::post('/postlogin', [LoginController::class, 'postlogin']);
Route::get('/register', [RegisterController::class, 'register']);
Route::post('/simpanregister', [RegisterController::class, 'simpanregister']);