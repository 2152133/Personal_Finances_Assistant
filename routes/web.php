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
    return view('pages.index');
});

Auth::routes();

<<<<<<< HEAD
Route::get('/home', 'HomeController@index')->name('home');


/*US26*/
Route::get('/me/dashboard', 'DashboardController@index');


Route::get('/', 'UserController@count');
Route::get('/users', 'UserController@index');
=======

Route::get('/users', 'UserController@index')->middleware('can:administrate')->name('users');



Route::patch('/users/{user}/block', 'UserController@block');
Route::patch('/users/{user}/unblock', 'UserController@unblock');
Route::patch('/users/{user}/promote', 'UserController@promote');
Route::patch('/users/{user}/demote', 'UserController@demote');
>>>>>>> us6

