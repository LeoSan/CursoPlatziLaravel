<?php

use App\Http\Controllers\{BitacoraController,
    CatalogoController,
    DiasInhabilesController,
    FormularioController,
    JurisdiccionController,
    PlantillaController};

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TipoInfraccionController;
// Catalogo
Route::group(['middleware' => ['permission:gestionar_usuarios']], function () {
    Route::prefix('usuarios')->group(function(){
        Route::get('/', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('usuarios');
        Route::get('/create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('usuarios.create');
        Route::post('/store', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('usuarios.store');
        Route::get('/permisos/{user_id}', [App\Http\Controllers\Admin\UserController::class, 'permisos'])->name('usuarios.permisos');
        Route::get('/{user_id}/{accion?}', [App\Http\Controllers\Admin\UserController::class, 'show'])->where(['user_id' => '[0-9]+'])->name('usuarios.show');
        Route::post('/storePermisos', [App\Http\Controllers\Admin\UserController::class, 'storePermisos'])->name('usuarios.storePermisos');
        Route::post('/getElementosEliminar', [App\Http\Controllers\Admin\UserController::class, 'getElmentosEliminarUsuario'])->name('usuarios.getElementosEliminar');
        Route::post('/eliminar', [App\Http\Controllers\Admin\UserController::class, 'eliminarUsuario'])->name('usuarios.eliminar');
        Route::post('getPerfilesByAreaId',[App\Http\Controllers\Admin\UserController::class,'getPerfilesByAreaId']);
    });
});
// Bitacora
Route::group(['middleware' => ['permission:gestionar_bitacoras']], function () {
    Route::get('bitacora',[BitacoraController::class,'index'])->name('bitacora.index');
});
// Catalogo
Route::group(['middleware' => ['permission:gestionar_catalogos']], function () {
    Route::prefix('catalogos')->name('catalogos.')->group(function(){
        Route::get('/', [CatalogoController::class,'index'])->name('index');
        Route::prefix('/{catalogo}')->group(function(){
            Route::get('/', [CatalogoController::class,'show'])->name('show');
            Route::post('/', [CatalogoController::class,'store'])->name('elementos.store');
        });
    });
});
// Días inhabiles
Route::group(['middleware' => ['permission:gestion_diasinhabiles']], function () {
    Route::prefix('diasinhabiles')->name('diasinhabiles.')->group(function(){
        Route::get('/', [DiasInhabilesController::class,'index'])->name('index');
        Route::post('/guardar-diasinhabiles', [DiasInhabilesController::class,'store'])->name('store');
    });
});
// Plantillas
Route::group(['middleware' => ['permission:gestionar_plantillas']], function () {
    Route::prefix('ati/plantillas')->name('plantillas.')->group(function(){
        Route::get('/', [PlantillaController::class,'index'])->name('index');
        Route::get('/create/{plantilla?}', [PlantillaController::class,'create'])->name('create');
        Route::post('/', [PlantillaController::class,'store'])->name('store');
        Route::post('/destroy', [PlantillaController::class,'destroy'])->name('destroy');
    });
    Route::prefix('ati/formularios')->name('formularios.')->group(function(){
        Route::get('/', [FormularioController::class,'index'])->name('index');
        Route::get('/create/{formulario?}', [FormularioController::class,'create'])->name('create');
        Route::post('/', [FormularioController::class,'store'])->name('store');
        Route::post('/destroy', [FormularioController::class,'destroy'])->name('destroy');
        Route::get('/activar/{formulario}', [FormularioController::class,'activar'])->name('activar');
        Route::prefix('/secciones')->name('secciones.')->group(function(){
            Route::post('/', [FormularioController::class,'storeSeccion'])->name('store');
            Route::post('/destroy', [FormularioController::class,'destroySeccion'])->name('destroy');
        });
        Route::prefix('/preguntas')->name('preguntas.')->group(function(){
            Route::post('/', [FormularioController::class,'storePregunta'])->name('store');
            Route::post('/destroy', [FormularioController::class,'destroyPregunta'])->name('destroy');
        });
        /*Route::get('/create/{plantilla?}', [PlantillaController::class,'create'])->name('create');
        Route::post('/', [PlantillaController::class,'store'])->name('store');
        Route::post('/destroy', [PlantillaController::class,'destroy'])->name('destroy');*/
    });
});



// Jurisdicción
Route::group(['middleware' => ['permission:gestionar_jurisdiccion']], function () {
    Route::prefix('ati/jurisdiccion')->name('jurisdiccion.')->group(function(){
        Route::get('/', [JurisdiccionController::class,'index'])->name('index');
        Route::post('/guardar', [JurisdiccionController::class,'update'])->name('update');
    });
});


/********* Seguimiento de casos *********/
Route::prefix('casos')->group(function () {
    Route::prefix('tiposInfraccion')->middleware(['permission:gestionar_tipos_infraccion'])->group(function () {
        Route::get('/', [TipoInfraccionController::class, 'index'])->name('tiposInfraccion.index');
        Route::get('/nuevo', [TipoInfraccionController::class, 'create'])->name('tiposInfraccion.create');
        Route::post('/deshabilitarEliminar', [TipoInfraccionController::class, 'deshabilitarEliminar'])->name('tiposInfraccion.deshabilitarEliminar');
        Route::post('/store', [TipoInfraccionController::class, 'store'])->name('tiposInfraccion.store');

    });
});

