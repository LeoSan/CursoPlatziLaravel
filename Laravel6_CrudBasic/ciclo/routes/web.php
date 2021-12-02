<?php

use Illuminate\Support\Facades\Route;

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
/*
Route::get('/', function () {
    return view('welcome');
});*/

Route::resource('users', "UserController");

Route::get('/', 'UserController@index');


//Route::resource('user', "UserController@index")->name('users.index');

Route::post('users', 'UserController@store')->name('users.store');//Esto quiete decir users-> nombre directorio. store-> Nombre unico asociado. 

Route::delete('users/{user}', 'UserController@destroy')->name('users.destroy');
