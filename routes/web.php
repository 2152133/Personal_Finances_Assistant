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
Route::get('/accounts/start', 'AccountController@getAllAccountsStart');
Route::get('/accounts/{user}', 'AccountController@listAllAccouts')->name('user.allAccounts');
Route::get('/accounts/{user}/opened', 'AccountController@openedAccounts')->name('user.openedAccounts');
Route::get('/accounts/{user}/closed', 'AccountController@closedAccounts')->name('user.closedAccounts');

// US15 -> close account
Route::patch('/account/{account}/close', 'AccountController@close');

//US16 -> reopen account
Route::patch('/account/{account}/reopen', 'AccountController@reopen');

// US18 -> edit accounts
Route::get('/account/{account}', 'AccountController@edit');

// US20 -> movements
Route::get('/movements/{account}', 'MovementsController@listMovements');


// US26 -> user dashboard page
Route::get('/me/dashboard', 'DashboardController@index');








