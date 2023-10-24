<?php

use App\Http\Controllers\ResolucionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ResolucionController::class,'index'])->name('resoluciones.index');
Route::get('/registro_demanda', [ResolucionController::class,'registroDenuncia'])->name('casos.resolucion.registro_demanda');
Route::post('/obtenerDetalleResolucion', [ResolucionController::class,'obtenerDetalleResolucion'])->name('casos.resolucion.obtener_detalle');

Route::get('/registro_demanda/{caso_id}', [ResolucionController::class,'registroDenuncia'])->name('casos.resolucion.registro_demanda.detalle');
Route::post('/crear_demanda', [ResolucionController::class,'crearDenuncia'])->name('casos.resolucion.crear_demanda');

Route::get('/convenio_pago/{caso_id}', [ResolucionController::class,'convenioPago'])->name('casos.resolucion.convenio_pago');
Route::post('/crear_convenio_pago', [ResolucionController::class,'crearConvenioPago'])->name('casos.resolucion.crear_convenio_pago');

Route::get('/pago_total/{caso_id}', [ResolucionController::class,'pagoTotal'])->name('casos.resolucion.pago_total');
Route::post('/crear_pago_total', [ResolucionController::class,'crearPagoTotal'])->name('casos.resolucion.crear_pago_total');
Route::post('/obtenerDetalleResolucion', [ResolucionController::class,'obtenerDetalleResolucion'])->name('casos.resolucion.obtener_detalle');
