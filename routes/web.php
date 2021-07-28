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

Route::get('/', 'ProductosController@welcome');

#Login view
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/registrarse', function () {
    return view('registrarse');
})->name('registrarse');

#Mi perfil
// Route::middleware(['role:Administrador'])->prefix('mi-perfil')->group(function () {
    Route::get('mi-perfil', 'MiPerfilController@index');
    Route::post('mi-perfil/update', 'MiPerfilController@update');
// });

#Route url
Route::post('login', 'LoginController@index');

#Logout url
Route::get('logout', 'LoginController@logout');

//Realizar-pedido
Route::get('/realizar-pedido', 'PedidosController@realizarPedido');
Route::post('/realizar-pedido/save', 'PedidosController@save');

//productos
Route::get('/productos', 'ProductosController@index');
Route::post('/productos/save', 'ProductosController@save');
Route::post('/productos/update', 'ProductosController@update');
Route::post('/productos/delete', 'ProductosController@delete');

//productos
Route::get('/clientes', 'UserController@index');
Route::post('/clientes/save', 'UserController@save');
Route::post('/clientes/update/productos', 'UserController@productos');
Route::post('/clientes/update/direcciones', 'UserController@direcciones');
Route::post('/clientes/update', 'UserController@update');
Route::post('/clientes/delete', 'UserController@delete');

//unidades
Route::get('/unidades', 'UnidadesController@index');
Route::post('/unidades/save', 'UnidadesController@save');
Route::post('/unidades/update', 'UnidadesController@update');
Route::post('/unidades/delete', 'UnidadesController@delete');

//Usuarios
Route::get('/administradores', 'AdministradoresController@index');
Route::post('/administradores/save', 'AdministradoresController@save');
Route::post('/administradores/update', 'AdministradoresController@update');
Route::post('/administradores/delete', 'AdministradoresController@delete');

//pedidos
Route::get('/pedidos', 'PedidosController@index');
Route::post('/pedidos/update', 'PedidosController@update');
Route::post('/pedidos/update/documentacion', 'PedidosController@updateDocumentacion');
Route::post('/pedidos/documentacion/download', 'PedidosController@downloadDocumentacion');
Route::get('/pedidos/excel/download', 'PedidosController@downloadExcel');
Route::post('/pedidos/delete', 'PedidosController@delete');
Route::get('/pedidos/mail', 'PedidosController@mail');
Route::post('/pedidos/status', 'PedidosController@status');

Route::get('/encuesta', 'ConfiguracionController@index');
Route::post('/encuesta/update', 'ConfiguracionController@update');