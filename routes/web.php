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

Route::get('/', array('as' => 'home', 'uses' => 'ProductosController@index'));

Auth::routes();


        Route::group(['prefix'=>'productos'],function () {
            Route::get('crear-producto', array('as' => 'crear_producto', 'uses' => 'ProductosController@create'));
        Route::post('guardar-producto', array('as' => 'guardar_producto', 'uses' => 'ProductosController@store'));


});



//Route::resource('productos','ProductosController');
//R    oute::get('home', array('as' => 'home', 'uses' => 'ProductosController@index'));




