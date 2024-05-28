<?php

use App\Http\Controllers\categoriaController;
use App\Http\Controllers\marcaController;
use App\Http\Controllers\presentacionController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProductoControllerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('template');
});

/*Route::get('/panel', function () {
    return view('panel.index')->name('panel');
});*/

Route::view('/panel', 'panel.index')->name('panel');


Route::resources([
    'categorias' => categoriaController::class,
    'marcas' => marcaController::class,
    'presentaciones' => presentacionController::class,
    'productos' => ProductoController::class

]);

/*Route::resource('categorias',categoriaController::class);

Route::resource('marcas',marcaController::class);

Route::resource('presentaciones',presentacionController::class);*/



Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/401', function () {
    return view('pages.401');
});

Route::get('/404', function () {
    return view('pages.404');
});

Route::get('/500', function () {
    return view('pages.500');
});
