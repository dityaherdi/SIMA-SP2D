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
        'rak' => 'API\RakController',
        'box' => 'API\BoxController',
        'surat' => 'API\SuratController',
        'arsip' => 'API\ArsipController',
        'user' => 'API\UserController'
    ]);
    
    // Get Letak
    Route::get('get-gedung', 'API\LetakController@letakGedung');
    Route::get('get-ruangan/{id}', 'API\LetakController@letakRuangan');
    Route::get('get-rak/{id}', 'API\LetakController@letakRak');
    Route::get('get-box/{id}', 'API\LetakController@letakBox');

    // Get Requirement Data Surat
    Route::get('get-skpd', 'API\RequirementSuratController@getSkpd');
    Route::get('get-jenis', 'API\RequirementSuratController@getJenis');

    // Search Data
    Route::get('search-skpd', 'API\SkpdController@search');
    Route::get('search-jenis', 'API\JenisSuratController@search');
    Route::get('search-gedung', 'API\GedungController@search');
    Route::get('search-ruangan', 'API\RuanganController@search');
    Route::get('search-rak', 'API\RakController@search');
    Route::get('search-box', 'API\BoxController@search');
    Route::get('search-surat', 'API\SuratController@search');
    Route::get('search-arsip', 'API\ArsipController@search');
    Route::get('search-user', 'API\UserController@search');

    // Profile
    Route::put('update-profile', 'API\ProfileController@updateProfile');

    // Dashboard
    Route::get('surat-today', 'API\DashboardController@suratToday');
    Route::get('arsip-today', 'API\DashboardController@arsipToday');
    Route::get('total-storage', 'API\DashboardController@totalStorage');
    Route::get('retensi-this-year', 'API\DashboardController@retensiThisYear');
    Route::get('latest-surat', 'API\DashboardController@latestSurat');
    Route::get('latest-arsip', 'API\DashboardController@latestArsip');
    Route::get('latest-retensi', 'API\DashboardController@latestRetensi');
    Route::get('detail-retensi', 'API\DashboardController@detailRetensi');
    Route::get('detail-surat', 'API\DashboardController@detailSurat');
    Route::get('detail-arsip', 'API\DashboardController@detailArsip');

    // Filter
    Route::get('ruangan-in-gedung/{id}', 'API\RuanganController@ruanganInGedung');
    Route::get('rak-in-ruangan/{id}', 'API\RakController@rakInRuangan');
    Route::get('rak-in-gedung/{id}', 'API\RakController@rakInGedung');
    Route::get('box-in-gedung/{id}', 'API\BoxController@boxInGedung');
    Route::get('box-in-ruangan/{id}', 'API\BoxController@boxInRuangan');
    Route::get('box-in-rak/{id}', 'API\BoxController@boxInRak');

    // Sort By SKPD
    Route::get('surat-by-skpd/{id}', 'API\SuratController@sortBySkpd');
    Route::get('arsip-by-skpd/{id}', 'API\ArsipController@sortBySkpd');

    // Retensi
    Route::get('retensi', 'API\RetensiController@index');
    Route::post('bulk-retensi', 'API\RetensiController@bulkRetensi');

    // Get Arsip In Box
    Route::get('get-arsip-in-box/{id}', 'API\BoxController@getArsipInBox');

    // Bukti Autentik
    Route::get('get-bukti-autentik', 'API\ArsipController@bukti');
    Route::post('bukti-done/{id}', 'API\ArsipController@buktiDone');
});