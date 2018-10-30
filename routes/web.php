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

Route::get('/single/blade','SingleController@show')->name('single');
Route::post('/single/upload','SingleController@store')->name('single.store');
Route::post('/single/delete','SingleController@delete')->name('single.delete');
Route::get('/single/get-preview','SingleController@getPreview')->name('single.get-preview');





Route::get('/twice/blade','TwiceController@show')->name('twice');

