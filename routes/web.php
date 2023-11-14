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

Auth::routes();



Route::get('LineaModulo', "Linea_Modulo@LinMod");

Route::post('paretos', "Reportes@Pareto");

Route::post('bihoral', "Reportes@Bihoral");

Route::post('grafico2', "Reportes@Grafico2");

Route::post('GraficoPlayera', "Reportes@GraficoPlayera");

Route::get('sockets', "Reportes@disparadorEventos");