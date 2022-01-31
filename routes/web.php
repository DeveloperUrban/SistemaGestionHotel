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
//Las rutas de la tabla Piso
Route::get('/piso', 'PisoController@index');
Route::post('/piso/registrar', 'PisoController@store');
Route::put('/piso/actualizar','PisoController@update');
Route::delete('/piso/eliminar/{id}','PisoController@destroy');
Route::get('/piso/selectPiso','PisoController@selectPiso');

//Las rutas de la tabla tipo habitacion
Route::get('/tipohabitacion', 'TipohabitacionController@index');
Route::post('/tipohabitacion/registrar', 'TipohabitacionController@store');
Route::put('/tipohabitacion/actualizar','TipohabitacionController@update');
Route::put('/tipohabitacion/desactivar','TipohabitacionController@desactivar');
Route::put('/tipohabitacion/activar','TipohabitacionController@activar');
Route::get('/tipohabitacion/selectTipohabitacion', 'TipohabitacionController@selectTipohabitacion');


//Las rutas de la tabla habitacion
Route::get('/habitacion', 'HabitacionController@index');
Route::post('/habitacion/registrar', 'HabitacionController@store');
Route::put('/habitacion/actualizar','HabitacionController@update');
Route::put('/habitacion/desactivar','HabitacionController@desactivar');
Route::put('/habitacion/activar','HabitacionController@activar');

//Las rutas de la tabla Categorias
Route::get('/categoria', 'CategoriaController@index');
Route::post('/categoria/registrar', 'CategoriaController@store');
Route::put('/categoria/actualizar','CategoriaController@update');
Route::put('/categoria/desactivar','CategoriaController@desactivar');
Route::put('/categoria/activar','CategoriaController@activar');
Route::get('/categoria/selectCategoria', 'CategoriaController@selectCategoria');



//Las rutas de la tabla SubCategorias
Route::get('/subcategoria', 'SubcategoriaController@index');
Route::post('/subcategoria/registrar', 'SubcategoriaController@store');
Route::put('/subcategoria/actualizar','SubcategoriaController@update');
Route::put('/subcategoria/desactivar','SubcategoriaController@desactivar');
Route::put('/subcategoria/activar','SubcategoriaController@activar');
Route::get('/subcategoria/selectSubcategoria', 'SubcategoriaController@selectSubcategoria');

//Las rutas de las tablas de Productos
Route::get('/producto', 'ProductoController@index');
Route::post('/producto/registrar', 'ProductoController@store');
Route::put('/producto/actualizar','ProductoController@update');
Route::put('/producto/desactivar','ProductoController@desactivar');
Route::put('/producto/activar','ProductoController@activar');


//Las rutas de la tabla Cliente
Route::get('/cliente', 'ClienteController@index');
Route::post('/cliente/registrar', 'ClienteController@store');
Route::put('/cliente/actualizar','ClienteController@update');
Route::put('/cliente/desactivar','ClienteController@desactivar');
Route::put('/cliente/activar','ClienteController@activar');
Route::get('/cliente/selectCliente','ClienteController@selectCliente');

//Las rutas para la cargar departamentos,provincias y distritos
Route::get('/departamento/selectDepartamento', 'UbigeController@selectDepartamento');
Route::get('/provincia/SelectProvincia', 'UbigeController@SelectProvincia');
Route::get('/distrito/SelectDistrito', 'UbigeController@SelectDistrito');

//Las rutas de la tabla recepciones
Route::get('/recepcion', 'RecepcionController@index');
Route::post('/recepcion/registrar', 'RecepcionController@store');
Route::put('/recepcion/desactivar','RecepcionController@desactivar');
Route::get('/recepcion/obtenerRecepcion','RecepcionController@obtenerRecepcion');


//Las rutas de la tabla venta
Route::get('/venta', 'VentaController@index');
Route::post('/venta/registrar', 'VentaController@store');
Route::put('/venta/actualizar','VentaController@update');
Route::put('/venta/desactivar','VentaController@desactivar');
Route::put('/venta/activar','VentaController@activar');