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
    return view('home');
})->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::post('system-management/region/search', 'RegionsController@search')->name('region.search');
Route::resource('system-management/region', 'RegionsController');


Route::post('user-management/search', 'UserManagementController@search')->name('user-management.search');   // named routes
Route::resource('user-management', 'UserManagementController');


// resourceful route
Route::resource('category', 'CategoryController');

/* Route::group(['middleware' => ['web']], function(){
    Route::resource('projects', 'ProjectsController');
}); */
Route::resource('projects', 'ProjectsController');


