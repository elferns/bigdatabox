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

Route::get('/admin/dashboard', 'admin\HomeController@index');
Route::get('/admin/pages', 'admin\PageController@index');
Route::post('/admin/pages/store', 'admin\PageController@store');
Route::delete('/api/destroy/{id}', 'admin\PageController@api_destroy');
Route::get('/api/page_details/{id}', 'admin\PageController@api_page');


//Route::get('/home', 'HomeController@index');
