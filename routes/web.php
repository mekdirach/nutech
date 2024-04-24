<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProdukController;
use Illuminate\Support\Facades\Route;

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
    return view('auth.login');
})->name('login');


Route::controller(LoginController::class)->group(function () {
    Route::post('/login', 'login')->name('login.process');
    Route::post('/logout', 'logout')->name('logout');
});

Route::group(['middleware' => 'checkauth'], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::prefix('produk')->group(function () {
        Route::get('/', [ProdukController::class, 'index'])->name('produk.index');
        Route::post('/list', [ProdukController::class, 'list'])->name('produk.list');
        Route::post('/create', [ProdukController::class, 'create'])->name('produk.create');
        Route::post('/show', [ProdukController::class, 'show'])->name('produk.show');
        Route::post('/edit', [ProdukController::class, 'edit'])->name('produk.edit');
        Route::post('/export', [ProdukController::class, 'export'])->name('produk.export');
        Route::delete('/delete/{id}', [ProdukController::class, 'delete'])->name('produk.delete');
    });
});
