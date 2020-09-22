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

Route::get('/', 'CustomerController@home')->name('home');

Route::post('add', 'CustomerController@addUser')->name('add');

Route::any('delete/{cid?}', 'CustomerController@deleteUser')->name('delete');

Route::any('edit/{userId?}', 'CustomerController@editUser')->name('editUser');

Route::post('editUserAction', 'CustomerController@editUserAction')->name('editUserAction');