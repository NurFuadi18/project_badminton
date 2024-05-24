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
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::get('/gantipassword', [HomeController::class, 'gantipassword']);
Route::post('/postlogin', [LoginController::class, 'postlogin']);
Route::get('/register', [RegisterController::class, 'register']);
Route::post('/simpanregister', [RegisterController::class, 'simpanregister']);




use App\Http\Controllers\TransactionController;

Route::middleware('auth')->group(function() {
    Route::get('transactions/{id}', [TransactionController::class, 'show'])->name('transaction.show');
    Route::get('transactions/{id}/print', [TransactionController::class, 'print'])->name('transaction.print');
});



use App\Http\Controllers\PdfController;

Route::get('/cetak-pdf', [PdfController::class, 'generatePdf']);

use App\Http\Controllers\MakananController;
Route::resource('barangs', MakananController::class);

use App\Http\Controllers\CartController;

    Route::middleware('auth')->group(function() {
    Route::post('cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::get('cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::delete('cart/{id}', [CartController::class, 'remove'])->name('cart.remove');
});

