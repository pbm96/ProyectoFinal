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
    return view('welcome');
});

Auth::routes();

    Route::get('home', array('as' => 'home', 'uses' => 'ProductosController@index'));
        Route::group(['prefix'=>'productos'],function () {
   Route::get('crear-producto', array('as' => 'crear_producto', 'uses' => 'ProductosController@create'));
   Route::post('guardar-producto', array('as' => 'guardar_producto', 'uses' => 'ProductosController@store'));

});



//Route::resource('productos','ProductosController');
//R    oute::get('home', array('as' => 'home', 'uses' => 'ProductosController@index'));


//    Route::post('crear-citas', array('as' => 'crear_citas_post', 'uses' => 'AgendasController@crear_agenda_post'));
//    Route::get('editar-agenda/{agenda_id}',['as' => 'editar_agenda','uses' => 'AgendasController@editar_agenda']);
//    Route::post('editar-agenda',['as' => 'editar_agenda_post','uses' => 'AgendasController@editar_agenda_post']);
//    Route::get('publicar-agenda', array('as' => 'publicar-agenda', 'uses' => 'AgendasController@publicar_agenda'));
//    Route::get('borrar-agenda',['as' => 'borrar_agenda','uses' => 'AgendasController@delete']);

