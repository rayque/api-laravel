<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

//Route::resource('usuario', 'UsuarioController');
Route::group(['prefix' => 'usuario/', 'name' => 'usuarios.'], function () {
    Route::get('listar', 'UsuarioController@listar')->name('listar');
    Route::post('store', 'UsuarioController@store')->name('store');
});



