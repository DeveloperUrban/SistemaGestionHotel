<?php

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
    return view('contenido/contenido');
});

Route::get('/piso', 'PisoController@index');
Route::post('/piso/registrar', 'PisoController@store');
Route::put('/piso/actualizar','PisoController@update');
Route::delete('/piso/eliminar/{id}','PisoController@destroy');

//Las rutas de la tabla tipo habitacion
Route::get('/tipohabitacion', 'TipohabitacionController@index');
Route::post('/tipohabitacion/registrar', 'TipohabitacionController@store');
Route::put('/tipohabitacion/actualizar','TipohabitacionController@update');
Route::put('/tipohabitacion/desactivar','TipohabitacionController@desactivar');
Route::put('/tipohabitacion/activar','TipohabitacionController@activar');


//Las rutas de la tabla habitacion
Route::get('/habitacion', 'HabitacionController@index');
Route::post('/habitacion/registrar', 'HabitacionController@store');
Route::put('/habitacion/actualizar','HabitacionController@update');
Route::put('/habitacion/desactivar','HabitacionController@desactivar');
Route::put('/habitacion/activar','HabitacionController@activar');
