<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Auth::routes();

Route::get( '/', 'PageController@index' )->name( 'home' );
Route::get('/home', 'PageController@index');

Route::get( 'tables', 'TableController@index' );
Route::get( 'tables-integration', 'TableController@integration' );
Route::get( 'table/{table}', 'TableController@detail' );
Route::post('tables-normalization', 'TableController@normalization_all' );
Route::post('table-normalization/{table}', 'TableController@normalization_table' );
Route::get( 'table/{table}/file-generate', 'TableController@file_generate' );
Route::get( 'table-remove/{table}', 'TableController@remove_normalization' );

Route::get( 'table/{table}/belongs', 'TableController@get_belongs' );
Route::get( 'table/{table}/hasmany', 'TableController@get_hasmany' );