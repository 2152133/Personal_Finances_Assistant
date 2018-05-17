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

Auth::routes();




/*US14*/
Route::get('/accounts/start', 'AccountsController@getAllAccountsStart');
Route::get('/accounts/{user}', 'AccountsController@getAllAccountsFromUser');

/*US26*/
Route::get('/me/dashboard', 'DashboardController@index');


Route::get('/users', 'UserController@index')->middleware('can:administrate')->name('users');



Route::patch('/users/{user}/block', 'UserController@block');
Route::patch('/users/{user}/unblock', 'UserController@unblock');
Route::patch('/users/{user}/promote', 'UserController@promote');
Route::patch('/users/{user}/demote', 'UserController@demote');



// home page
Route::get('/home', 'HomeController@index')->name('home');

// change user password
Route::get('/me/password', 'UserController@editPassword')->name('user.editPassword');
Route::patch('/me/password', 'UserController@updatePassword')->name('user.updatePassword');

// update user profile
Route::get('/me/profile', 'UserController@editProfile')->name('user.editProfile');
Route::put('/me/profile', 'UserController@updateProfile')->name('user.updateProfile');

// list profiles
Route::get('/profiles', 'UserController@listProfiles')->name('user.listProfiles');


