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
Route::get('/accounts/{user}', 'AccountsController@getAllAccountsFromUser');
Route::get('/accounts/{user}/opened', function($user){
	return view();
});
Route::get('/accounts/{user}/closed', function($user){
	return view();
});
//Route::get('/accounts/start', 'AccountsController@getAllAccountsStart');

// US20 -> movements
Route::get('/movements/{account}', 'MovementsController@listMovements');

// US21 -> movements
Route::get('/movements/{account}/create', 'MovementsController@showAddMovementForm');
Route::post('/movements/{account}/create', 'MovementsController@addMovement')->name('addMovement');
Route::get('/movements/{account}/{movement}', 'MovementsController@showEditMovementForm');
Route::put('/movements/{account}/{movement}', 'MovementsController@editMovement');
Route::delete('/movements/{account}/{movement}', 'MovementsController@deleteMovement');

// US26 user dashboard page
Route::get('/me/dashboard', 'DashboardController@index');



