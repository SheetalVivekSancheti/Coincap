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

Route::get('/','HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/admin/dashboard','AdminController@index');
Route::post('/admin/dashboard','AdminController@storeCoin');
Route::get('/admin','AdminController@listAdmin');
Route::get('/admin/create','AdminController@createAdmin');
Route::post('/admin/create','AdminController@insertAdmin');
Route::get('/changePassword','HomeController@changePassword');
Route::post('/changePassword','HomeController@updatePassword');
Route::get('/test',function() {
    return view('test');
});
Route::get('/{coin}','CoinController@showDetails');

