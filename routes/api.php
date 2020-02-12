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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/lesentetes', 'ScanController@getentetes')->name('lesentetes');
Route::post('/lespdfs', 'ScanController@getlespdfs')->name('lespdfs');
Route::post('/lirepdf', 'ScanController@getPdfbyName')->name('urlpdf');
Route::post('/saveenetetesinfile', 'ScanController@saveenetetesinfile')->name('saveenetetes');