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
Route::get('/twice/{id}/{type}/get-preview','TwiceController@getPreview')->name('twice.get-preview');
Route::post('/twice/delete','TwiceController@delete')->name('twice.delete');
Route::post('/twice/upload','TwiceController@store')->name('twice.store');

Route::get('/gallery/blade','GalleryController@show')->name('gallery');
Route::post('/gallery/upload','GalleryController@store')->name('gallery.store');
Route::post('/gallery/delete','GalleryController@delete')->name('gallery.delete');
Route::get('/gallery/{id}/{type}/get-preview','GalleryController@getPreview')->name('gallery.get-preview');

Route::get('/resizable/blade','ResizableController@show')->name('resizable');
Route::post('/resizable/upload','ResizableController@store')->name('resizable.store');
Route::post('/resizable/delete','ResizableController@delete')->name('resizable.delete');
Route::get('/resizable/{id}/{type}/get-preview','ResizableController@getPreview')->name('resizable.get-preview');
