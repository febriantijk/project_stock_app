<?php

use App\Http\Controllers\Authcontroller;
use App\Http\Controllers\barangkeluarcontroller;
use App\Http\Controllers\dashboardcontroller;
use App\Http\Controllers\pegawaicontroller;
use App\Http\Controllers\pelanggancontroller;
use App\Http\Controllers\stokcontroller;
use App\Http\Controllers\supliercontroller;
use App\Http\Controllers\barangmasukcontroller;
use App\Http\Controllers\barangmasukcontroller\barangmasukcontroller as BarangmasukcontrollerBarangmasukcontroller;
use App\Http\Middleware\Auth;
use App\Http\Middleware\CekLevel;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[Authcontroller::class,'index']);
Route::post('/',[Authcontroller::class,'login'])->name('login');



Route::middleware(['auth', 'ceklevel:superadmin,admin'])->group(function(){


    Route::get('/dashboard', [dashboardcontroller::class, 'index']);

    Route::get('/logout', [AuthController::class, 'logout']);

/**
 * ini untuk routing pegawai
 */

    Route::controller(pegawaicontroller::class)->group(function(){

        Route::get('/pegawai','index');

        Route::post('/pegawai/add', 'store')->name('addpegawai');

        Route::get('pegawai/edit/{id}', 'edit');
        Route::post('pegawai/edit/{id}', 'update');

        Route::get('/pegawai/delete/{id}', 'destroy');
    });

    /**
     * ini routing suplier
     */

    Route::controller(supliercontroller::class)->group(function(){



    Route::get('/suplier', 'index');

    Route::get('/suplier/add', 'create');
    Route::post('/suplier/add', 'store');

    Route::get('/suplier/edit/{id}', 'edit');
    Route::post('/suplier/edit/{id}', 'update');

    Route::get('/suplier/{id}', 'destroy');
});

    /**
     * ini routing pelanggan
     */
  Route::controller(pelanggancontroller::class)->group(function(){

    Route::get('/pelanggan', 'index');

    Route::get('/pelanggan/add', 'create');
    Route::post('/pelanggan/add', 'store');

    Route::get('/pelanggan/edit/{id}', 'edit');
    Route::post('/pelanggan/edit/{id}', 'update');

    Route::get('/pelanggan/{id}', 'destroy');
  });

  /**
   * ini routing stok
   */
    Route::controller(stokcontroller::class)->group(function(){

        Route::get('/stok', 'index');
        Route::get('/stok/add', 'create');
        Route::post('/stok/add', 'store');

        Route::get('/stok/edit/{id}', 'edit');
        Route::post('/stok/edit/{id}', 'update');
        Route::get('/stok/{id}', 'destroy');


    });

    /**
     * ini routing barang masuk
     */
    Route::controller(Barangmasukcontroller::class)->group(function(){
        Route::get('/barang-masuk', 'index');
        Route::get('/barang-masuk/add', 'create');
        Route::post('/barang-masuk/add', 'store');

        Route::get('/barang-masuk/edit/{id}', 'edit');
        Route::post('/barang-masuk/edit/{id}', 'update');
        Route::get('/barang-masuk/{id}', 'destroy');


    });

    /**
     * ini routing barang keluar
     */
    Route::controller(barangkeluarcontroller::class)->group(function(){
        Route::get('/barang-keluar', 'index');

        Route::get('/barang-keluar/add', 'create');
        Route::post('/barang-keluar/add', 'store');
        

        Route::post('/barang-keluar/save', 'savebarangkeluar')->name('addbarangkeluar');
        Route::get('/barang-keluar/print/{id}', 'print');
        Route::get('/barang-keluar/{id}', 'destroy');


    });





});
