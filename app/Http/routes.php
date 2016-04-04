<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

/** Routes for dashboard */
Route::get('/admin/dashboard', 'admin\HomeController@index');

/** Routes for pages */
Route::get('/admin/pages', 'admin\PageController@index');
Route::post('/admin/pages/store', 'admin\PageController@store');
Route::delete('/api/destroy/{id}', 'admin\PageController@api_destroy');
Route::get('/api/page_details/{id}', 'admin\PageController@api_page');

/** Routes for banners */
Route::get('/admin/banners', 'admin\BannerController@index');
Route::post('/admin/banners/store', 'admin\BannerController@store');
Route::get('/admin/banners/list', 'admin\BannerController@api_list');
