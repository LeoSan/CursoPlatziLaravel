<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/post/form/',[PostController::class,'showPost'])->name('form.post');
Route::get('/post/formAjax/',[PostController::class,'showPostAjax'])->name('form.post.ajax');

Route::post('/post/store',[PostController::class,'storePost'])->name('store.post');
Route::post('/post/store/ajax',[PostController::class,'storePostAjax'])->name('store.post.ajax');

