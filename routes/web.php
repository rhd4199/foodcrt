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

Route::get('/', function () {return view('page-login');});

//login
Route::post('/login','loginController@login');
Route::get('/logout','loginController@logout');

// dashboard
Route::get('/dashboard','dashboardController@index');

//kasir
Route::get('/kasir','kasirController@index');
Route::post('/cari','kasirController@search');
Route::post('/cari_harga','kasirController@search2');
Route::get('/cari_tenan','kasirController@search3');


// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
