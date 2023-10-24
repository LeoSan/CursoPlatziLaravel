<?php

use App\Http\Controllers\CasoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CasoController::class,'index'])->name('casos.index');
Route::get('/tablero', [CasoController::class,'tablero'])->name('casos.tablero');
Route::get('/reporte', [CasoController::class,'reporte'])->name('casos.reporte');
Route::post('/reporteMensualPagos', [CasoController::class,'reporteMensualPagos'])->name('reporte_mensual_pagos');

Route::group(['middleware' => ['permission:registrar_caso']], function () {
	Route::get('/registro', [CasoController::class,'show'])->name('casos.registro');
});

Route::post('/store', [CasoController::class,'store'])->name('casos.store');
Route::post('/notificarPGR', [CasoController::class,'notificarPGR'])->name('casos.notificarPGR');

Route::get('/{id}/informacion', [CasoController::class,'show'])->name('casos.informacion');
Route::get('/resumen/{caso_id}/{tab_activa?}', [CasoController::class,'getResumen'])->name('casos.getResumen');
Route::post('/datos_pgr', [CasoController::class,'actualizarDatosPGR'])->name('casos.actualizar.datos.pgr');
Route::delete('/eliminar_caso', [CasoController::class,'eliminarCaso'])->name('casos.eliminar');

Route::get('/{id}/turno/{tipo}', [CasoController::class,'turno'])->name('casos.turno');
Route::get('/{id}/rechazo/{tipo}', [CasoController::class,'rechazo'])->name('casos.rechazo');

Route::get('/{id}/resolucion/iniciar_proceso', [CasoController::class,'resolucionIniciarProceso'])->name('casos.resolucion_iniciar_proceso');

Route::post('/turno', [CasoController::class,'turnar'])->name('casos.turnar');
Route::post('/rechazo', [CasoController::class,'turnar'])->name('casos.rechazar');

Route::get('/{id}/no-procedente', [CasoController::class,'no_procedente'])->name('casos.no-procedente');
Route::post('/no-procedente', [CasoController::class,'noProcedenteCrear'])->name('casos.no-procedente-crear');

Route::get('{id}/otro-descargo', [CasoController::class,'showOtroDescargo'])->name('casos.showOtroDescargo');
Route::post('{id}/info-pendiente', [CasoController::class,'cambioInfoPendiente'])->name('casos.cambioInfoPendiente');
Route::post('/storeOtroDescargo', [CasoController::class,'storeOtroDescargo'])->name('casos.storeOtroDescargo');


// CONVENIO
Route::post('/convenio-pago', [CasoController::class,'convenioPago'])->name('convenio.pago');
Route::post('/convenio-concluir', [CasoController::class,'convenioConcluir'])->name('convenio.concluir');
