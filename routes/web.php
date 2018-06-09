<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now  something great!
|
*/



// US1 -> main page
Route::get('/', function () {	
	return view('welcome');
});

// US2,3,4,8 -> register, login, forgot password, logout
Auth::routes();

// US5-6 -> list users profiles (admin)
Route::get('/users', 'UserController@edit')->middleware('can:administrate')->name('users');

//US7 -> operacoes no utilizador
Route::patch('/users/{user}/block', 'UserController@block')->middleware('can:administrate');
Route::patch('/users/{user}/unblock', 'UserController@unblock')->middleware('can:administrate');
Route::patch('/users/{user}/promote', 'UserController@promote')->middleware('can:administrate');
Route::patch('/users/{user}/demote', 'UserController@demote')->middleware('can:administrate');

// US9 -> change user password
Route::get('/me/password', 'UserController@editPassword')->name('user.editPassword');
Route::patch('/me/password', 'UserController@updatePassword')->name('user.updatePassword');

// US10 -> update user profile
Route::get('/me/profile', 'UserController@editProfile')->name('user.editProfile');
Route::put('/me/profile', 'UserController@updateProfile')->name('user.updateProfile');

// US11 -> list users profiles (users)
Route::get('/profiles', 'UserController@listProfiles')->name('user.listProfiles');

// US12 -> list users associated to my group
Route::get('me/associates', 'UserController@listAssociates')->name('user.listAssociates');

// US13 -> list user associated to other groups
Route::get('me/associate-of', 'UserController@listAssociateOf')->name('user.listAssociateOf');

// US14 -> view my accounts (opened/closed)
Route::get('/accounts/{user}', 'AccountController@listAllAccouts')->name('user.allAccounts');
Route::get('/accounts/{user}/opened', 'AccountController@openedAccounts')->name('user.openedAccounts');
Route::get('/accounts/{user}/closed', 'AccountController@closedAccounts')->name('user.closedAccounts');

// US15 -> close account
Route::patch('/account/{account}/close', 'AccountController@close');
Route::delete('/account/{account}', 'AccountController@delete');

//US16 -> reopen account
Route::patch('/account/{account}/reopen', 'AccountController@reopen');

// US17 -> create account
Route::get('/account', 'AccountController@create')->middleware('can:create')->name('user.createAccount');
Route::post('/account', 'AccountController@store')->middleware('can:create')->name('user.storeAccount');

// US18 -> edit accounts
Route::get('/account/{account}', 'AccountController@edit');
Route::put('/account/{account}', 'AccountController@updateAccount')->name('user.updateAccount');


Route::get('/view/{movement}', 'MovementController@viewFile');
Route::get('/download/{movement}', 'MovementController@downloadFile');


// US20 -> list movements
Route::get('/movements/{account}', 'MovementController@listAllMovements')->middleware('can:view-account-movements,account');

//US21 -> create, update and delete movements
Route::get('/movements/{account}/create', 'MovementController@create');
Route::post('/movements/{account}/create', 'MovementController@store')->name('user.storeMovement');
Route::get('/movement/{movement}', 'MovementController@edit');
Route::put('/movement/{movement}', 'MovementController@update')->name('user.updateMovement');
Route::delete('/movement/{movement}', 'MovementController@delete');


//US23 -> add document
Route::get('/documents/{movement}', 'MovementController@createDocument');
Route::post('/documents/{movement}', 'MovementController@storeDocument');
	
//US24 -> delete document
Route::delete('/document/{document}', 'MovementController@deleteDocument');

//US25 -> download/view document
Route::get('/document/download/{document}', 'MovementController@download');
Route::get('/document/view/{document}', 'MovementController@view');

// US26 user dashboard page
Route::get('/dashboard/{user}', 'DashboardController@index')->name('dashboard');


// US27 statistics
Route::get('/statistics', 'StatisticsController@index');


Route::post('/users/{user}/associate', 'UserController@addToMyGroup');
Route::delete('/users/{user}/dessociate', 'UserController@removeFromMyGroup');





