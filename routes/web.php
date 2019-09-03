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

Route::get('/', 'DashboardRegionalController@home')->name('home');

Route::get('home', 'DashboardRegionalController@home')->name('home');
Route::get('home/{page}', 'DashboardRegionalController@home')->name('home.paginate');
Route::get('nodeb', ['as' => 'nodeb', 'uses' => 'NodebController@index']); 
Route::get('user', ['as' => 'user', 'uses' => 'UserController@index']);
Route::get('/Dashboard/filter', 'DashboardRegionalController@filter')->name('dashboard.filter');
Route::get('/Dashboard/filterinner', 'DashboardRegionalController@filter_inner')->name('dashboard.filter_inner');
Route::get('/Dashboard/pagination', 'DashboardRegionalController@paginationAllOcc')->name('dashboard.pagination');
// Route::get('/home/page/{page}', 'DashboardRegionalController@paginationAllOcc')->name('home.paginate');
Route::get('/witel/{witel}/category/{category}', 'AlertWitelController@alertdetail')->name('alert.detail');
Route::get('/treg/{treg}/category/{category}', 'AlertWitelController@alertTregdetail')->name('alertTreg.detail');
// Route::get('/witel/{id}/category/{category}', function ($id, $category) {
//     return "Witel {$id}";
// })->name('alert.detail');
