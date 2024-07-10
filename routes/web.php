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

Route::get('/AjedrezMP', 'AjedrezMPController@elegir')->name('Ajedrez');

Route::get('/AjedrezIA', 'AjedrezIAController@elegir')->name('Ajedrez');


Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/TresRaya', 'TresRayaController@elegir')->name('TresRaya');

//Route::get('/Ajedrez', 'AjedrezController@elegir')->name('Ajedrez');
Route::post('/Amigos', 'AmigosController@amigos')->name('Amigos');
