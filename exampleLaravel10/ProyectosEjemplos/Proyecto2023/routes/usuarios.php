<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

///********* GESTION DE USUARIOS *********/
//Route::group(['middleware' => ['permission:gestionar_usuarios']], function () {
//    Route::get('/', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('usuarios');
//    Route::get('/create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('usuarios.create');
//    Route::post('/store', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('usuarios.store');
//    Route::get('/permisos/{user_id}', [App\Http\Controllers\Admin\UserController::class, 'permisos'])->name('usuarios.permisos');
//    Route::get('/{user_id}/{accion?}', [App\Http\Controllers\Admin\UserController::class, 'show'])->where(['user_id' => '[0-9]+'])->name('usuarios.show');
//    Route::post('/storePermisos', [App\Http\Controllers\Admin\UserController::class, 'storePermisos'])->name('usuarios.storePermisos');
//    Route::post('/getElementosEliminar', [App\Http\Controllers\Admin\UserController::class, 'getElmentosEliminarUsuario'])->name('usuarios.getElementosEliminar');
//    Route::post('/eliminar', [App\Http\Controllers\Admin\UserController::class, 'eliminarUsuario'])->name('usuarios.eliminar');
//});
