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

Route::get('home', ['as' => 'home', 'uses' => 'DashboardRegionalController@index']); 
Route::get('nodeb', ['as' => 'nodeb', 'uses' => 'NodebController@index']); 
Route::get('user', ['as' => 'user', 'uses' => 'UserController@index']);
Route::get('/Dashboard/filter', 'DashboardRegionalController@filter')->name('dashboard.filter');
Route::get('/Dashboard/pagination', 'DashboardRegionalController@paginationAllOcc')->name('dashboard.pagination');
