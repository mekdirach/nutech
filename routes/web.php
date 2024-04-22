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
    Route::get('/logout', 'logout')->name('logout');
});

Route::group(['middleware' => 'checkauth'], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::group(['prefix' => 'produk'], function () {
        Route::controller(ProdukController::class)->group(function () {
            Route::get('/', 'index')->name('produk.index');
            Route::post('/list', 'ProdukController@list')->name('produk.list');
            Route::post('/create', 'ProdukController@create')->name('produk.create');
        });
    });
});
