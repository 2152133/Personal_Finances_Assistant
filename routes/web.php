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

<<<<<<< HEAD
// US12 -> list users associated to my group
Route::get('me/associates', 'UserController@listAssociates')->name('user.listAssociates');

// US13 -> list user associated to other groups
Route::get('me/associate-of', 'UserController@listAssociateOf')->name('user.listAssociateOf');

// US14 -> view my accounts (opened/closed)
Route::get('/accounts/{user}', 'AccountController@listAllAccouts')->name('user.allAccounts');
Route::get('/accounts/{user}/opened', 'AccountController@listOponedAccouts')->name('user.openedAccounts');;
Route::get('/accounts/{user}/closed', 'AccountController@listClosedAccouts')->name('user.closedAccounts');;

// US17 -> create account
Route::get('/account', 'AccountController@create')->name('user.createAccount');
Route::post('/account', 'AccountController@store')->name('user.storeAccount');

=======
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
>>>>>>> 313818cbef5df7b6aa526497da51e66522fff96b

// US26 user dashboard page
Route::get('/me/dashboard', 'DashboardController@index')->name('dashboard');



