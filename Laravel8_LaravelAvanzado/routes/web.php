<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController; 
use Illuminate\Support\Facades\Auth;


Route::get('/',  [PageController::class, 'home' ] )->name('home');
Route::get('/curso/{id}',  [PageController::class, 'course' ] )->name('course');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


//Auth::routes(["verify" => true]); 


Route::get('/comando',  [PageController::class, 'comandoActivo' ] )->name('comandoActivo');