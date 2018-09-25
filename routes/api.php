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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'api'], function ($router) {
    Route::post('login', 'AuthController@login');    
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::group(['middleware' => 'auth:api'], function (){
    
    Route::apiResources([
        'skpd' => 'API\SkpdController',
        'jenis' => 'API\JenisSuratController',
        'gedung' => 'API\GedungController',
        'ruangan' => 'API\RuanganController',
        'rak' => 'API\RakController'
    ]);

    Route::get('get-gedung', 'API\LetakController@letakGedung');
    Route::get('get-ruangan/{id}', 'API\LetakController@letakRuangan');
    Route::get('get-rak/{id}', 'API\LetakController@letakRak');
    // Route::get('get-box', 'API\LetakController@letakBox');
    
    // Route::get('get-gedung', 'API\GedungController@getGedung');
    // Route::get('get-ruangan', 'API\RuanganController@getRuangan');
});