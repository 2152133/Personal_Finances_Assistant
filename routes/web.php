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



// US1 -> main page
Route::get('/', function () {	
    return view('welcome');
});

// US2,3,4,8 -> register, login, forgot password, logout
Auth::routes();

// US5-6 -> list users profiles (admin)
Route::get('/users', 'UserController@index')->middleware('can:administrate')->name('users');

//US7 -> operacoes no utilizador
Route::patch('/users/{user}/block', 'UserController@block');
Route::patch('/users/{user}/unblock', 'UserController@unblock');
Route::patch('/users/{user}/promote', 'UserController@promote');
Route::patch('/users/{user}/demote', 'UserController@demote');

// US9 -> change user password
Route::get('/me/password', 'UserController@editPassword')->name('user.editPassword');
Route::patch('/me/password', 'UserController@updatePassword')->name('user.updatePassword');

// US10 -> update user profile
Route::get('/me/profile', 'UserController@editProfile')->name('user.editProfile');
Route::put('/me/profile', 'UserController@updateProfile')->name('user.updateProfile');

// US11 -> list users profiles (users)
Route::get('/profiles', 'UserController@listProfiles')->name('user.listProfiles');

// US14 -> accounts
Route::get('/accounts/start', 'AccountsController@getAllAccountsStart');
Route::get('/accounts/{user}', 'AccountsController@getAllAccountsFromUser');

// US26 user dashboard page
Route::get('/me/dashboard', 'DashboardController@index');



