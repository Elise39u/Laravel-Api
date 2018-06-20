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

Route::any('/', 'AdminPanel@login')->name('Login');
Route::match(['get', 'post'],'Login','AdminPanel@loginProcess');
Route::match(['get', 'post'],'logout','AdminPanel@logout');
Route::any('dashboard', 'AdminPanel@dashboard')->name('dashboard');
Route::match(['get', 'post'], 'users', 'AdminPanel@users')->name('users');
	Route::match(['get', 'post'], 'CreateEmployee','AdminPanel@InsertEmployee');
	Route::match(['get', 'post'], 'CreateGuest','AdminPanel@InsertGuest');
	Route::any('DeleteEmployee','AdminPanel@DeleteEmployee');
	Route::any('FreezeUser','AdminPanel@FreezeUser');
	Route::any('EditUser','AdminPanel@EditUser');
Route::any('roles', 'AdminPanel@roles')->name('roles');
	Route::any('DeleteRole', 'AdminPanel@DeleteRole');
	Route::any('EditRole', 'AdminPanel@EditRole');
	Route::any('AddRole', 'AdminPanel@AddRole');
Route::any('logs', 'AdminPanel@logs')->name('logs');
Route::any('api', 'AdminPanel@api')->name('api');
Route::any('phpcheck', 'AdminPanel@phpcheck')->name('info');
