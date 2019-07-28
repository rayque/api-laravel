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


Route::group(['prefix' => 'usuario/',], function () {
    Route::get('listar', 'UsuarioController@listar');
    Route::post('store', 'UsuarioController@store');
    Route::post('destroy', 'UsuarioController@destroy');
    Route::post('update', 'UsuarioController@update');
    Route::get('get-dados/{id}', 'UsuarioController@getDados');
    Route::get('relatorio', 'UsuarioController@relatorio');
});

Route::group(['prefix' => 'perfil/', 'name' => 'perfis.'], function () {
    Route::get('listar-perfis', 'PerfilController@listarPerfis');
});
Route::group(['prefix' => 'aparelho/', 'name' => 'aparelho.'], function () {
    Route::get('listar-aparelhos', 'AparelhoController@listarAparelhos');
});


