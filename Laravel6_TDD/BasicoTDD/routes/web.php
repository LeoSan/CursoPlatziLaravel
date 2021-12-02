<?php

use Illuminate\Support\Facades\Route;

//Importo Controladores
use App\Http\Controllers\RepositoryController;

Route::get('/', [App\Http\Controllers\PageController::class ,'home']);


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


//Proporciono las 7 Rutas y le coloco candado de seguridad con middleware
Route::resource('repositories', RepositoryController::class)->middleware('auth');

