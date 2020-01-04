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

Route::get('/', 'commentController@index');

Route::get('/page1', 'commentController@page1')->name('page1');

Route::get('/page2', 'commentController@page2')->name('page2');


Route::post('/comment','commentController@store');
Route::get('/comment/{url}','commentController@forum');

Route::put('/comment','commentController@edit');
Route::DELETE	('/comment/{id}','commentController@destroy');
