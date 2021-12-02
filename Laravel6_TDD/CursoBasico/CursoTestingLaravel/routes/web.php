<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;

//Ejemplo del miniproyecto
Route::get('/', function () {
    return view('welcome', [
        'tags' => App\Models\Tag::get()
    ]);
});


Route::post('tags', [TagController::class,  'store']);

Route::delete('tags/{tag}', [TagController::class,  'destroy']);


//ejemplo de pruebas 
Route::view('profile', 'profile');

Route::post('profile', [ProfileController::class, 'upload']);


