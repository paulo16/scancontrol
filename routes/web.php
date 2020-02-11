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

Route::get('/', function (){
    return view('vue');
});

Route::get('/{any?}', function (){
    return view('vue');
})->where('any', '[A-Za-z0-9]+')->name("any");

Route::get('/scanpdf', function (){
    return view('vue');
})->name('scanpdf');