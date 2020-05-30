<?php

use Illuminate\Http\Request;

/*php
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources([
    'user'          => 'API\UserController'
    , 'categoria'   => 'API\CategoriaController'
    , 'empresa'     => 'API\EmpresaController'
    , 'curso'       => 'API\CursoController'
    , 'modulo'       => 'API\ModuloController'
    , 'documento'       => 'API\DocumentoController'
    , 'pregunta'       => 'API\PreguntaController'
]);

Route::namespace('API')->group(function () {
    Route::get('profile', 'UserController@profile');
    Route::get('findUser', 'UserController@search');
    Route::get('getTutors', 'UserController@getTutors');
    Route::get('getModules/{id_curso}', 'ModuloController@getModules');
    Route::get('getDocumentos/{id_modulo}', 'DocumentoController@getDocumentos');
    Route::get('getPreguntas/{id_modulo}', 'PreguntaController@getPreguntas');
    Route::put('profile', 'UserController@updateProfile');

    

    Route::get('findCategoria', 'CategoriaController@search');
    Route::get('findEmpresa', 'EmpresaController@search');
    Route::get('findCurso', 'CursoController@search');
    Route::get('findModulo', 'ModuloController@search');
});