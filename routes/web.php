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
    return view('auth.login');
});
Auth::routes();

Route::get('home', 'DashboardRegionalController@home')->name('home');
Route::get('home/{page}', 'DashboardRegionalController@home')->name('home.paginate');

Route::get('nodeb', ['as' => 'nodeb', 'uses' => 'NodebController@index'])->middleware('akses.admin'); 
Route::get('/nodeb/witel', 'NodebController@findWitel')->name('nodeb.witel');

Route::get('/nodebReg', 'NodebRegController@index')->name('nodebReg'); 

Route::get('user', ['as' => 'user', 'uses' => 'UserController@index'])->middleware('akses.admin');
Route::post('/user/store','UserController@store');
Route::get('/user/edit/{id}','UserController@edit');
Route::get('/user/delete/{id}','UserController@delete');

Route::get('/Dashboard/filter', 'DashboardRegionalController@filter')->name('dashboard.filter');
Route::get('/Dashboard/filterinner', 'DashboardRegionalController@filter_inner')->name('dashboard.filter_inner');
Route::get('/Dashboard/pagination', 'DashboardRegionalController@paginationAllOcc')->name('dashboard.pagination');

Route::get('/witel/{witel}/category/{category}', 'AlertWitelController@alertdetail')->name('alert.detail');
Route::get('/treg/{treg}/category/{category}', 'AlertWitelController@alertTregdetail')->name('alertTreg.detail');

Route::get('/grafik/{site_name}/siteid/{site_id}', 'AlertWitelController@alertgrafik')->name('alert.grafik');
Route::get('/grafik/filter', 'AlertWitelController@alertgrafikFilter')->name('alert.grafikFilter');

Route::get('/boxes/treg/all', 'BoxesController@occCriticalAll')->name('boxes.all');
Route::get('/boxes/treg/{treg}', 'BoxesController@occCriticalTreg')->name('boxes.treg');

//notes
// Route::get('/home/page/{page}', 'DashboardRegionalController@paginationAllOcc')->name('home.paginate');
// Route::get('/witel/{id}/category/{category}', function ($id, $category) {
//     return "Witel {$id}";
// })->name('alert.detail');


