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
//ruta home principal
Route::get('/', array('as' => 'index', 'uses' => 'ProductosController@index'));

//rutas autentificacion (login/registro)
Auth::routes();

        //rutas de los productos. para acceder hay que autentificarse
        Route::group(['prefix'=>'productos','middleware'=>'auth'],function () {
             Route::get('crear-producto', array('as' => 'crear_producto', 'uses' => 'ProductosController@create'));
            Route::post('guardar-producto', array('as' => 'guardar_producto', 'uses' => 'ProductosController@store'));

            Route::get('{id}/borrar',array( 'as' =>'borrar_producto','uses'=>'ProductosController@destroy'));

            Route::get('{id}/editar',array( 'as' =>'editar_producto','uses'=>'ProductosController@edit'));

            Route::get('ver-producto/{id}',array('as'=>'ver_producto','uses'=>'ProductosController@ver_producto_completo'));


        });
        Route::group(['prefix'=>'usuario'],function () {

        });



//Route::resource('productos','ProductosController');




