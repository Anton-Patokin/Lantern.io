<?php

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

// all events
Route::post('/bridge/pusher/slideshow/start', 'PusherController@start_slideshow');
Route::post('/bridge/pusher/slideshow/stop', 'PusherController@stop_slideshow');
Route::post('/bridge/pusher/slideshow/move', 'PusherController@move_slide');
Route::post('/bridge/pusher/slideshow/options', 'PusherController@send_options');
Route::post('/bridge/pusher/slideshow/active', 'PusherController@is_active');

// delete
Route::post('/file/delete ', 'FileController@file_delete');

// upload
Route::post('/file/upload', 'FileController@file_upload');

// get all files
Route::get('/{title}/get-files', 'RoomController@get_documents_room');
