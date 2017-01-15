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

// homepage
Route::get('/', 'RoomController@index');

// make playlist
Route::post('/make/room', 'RoomController@create_room');

// playlist routes
Route::get('/{title}','RoomController@show_room');
Route::post('/password','RoomController@access_room');
Route::get('/list/{title}','AccessController@index');
Route::get('/download/list/{title}','RoomController@download_room');
