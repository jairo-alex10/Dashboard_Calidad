<?php

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
    return view('welcome');
});

Route::get('LineaModulo', "App\Http\Controllers\Linea_Modulo@LinMod");

Route::post('pareto', "App\Http\Controllers\Reportes@Pareto");

Route::post('bihoral', "App\Http\Controllers\Reportes@Bihoral");

Route::post('grafico2', "App\Http\Controllers\Reportes@Grafico2");

Route::post('GraficoPlayera', "App\Http\Controllers\Reportes@GraficoPlayera");
