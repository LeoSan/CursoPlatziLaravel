<?php

use App\Http\Controllers\PlaneacionesController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PlaneacionesController::class, 'planeaciones'])->name('planeaciones');
Route::get('/planeacion/{id}', [PlaneacionesController::class, 'planeacion'])->name('planeaciones.planeacion');

Route::get('/planeacion/crear', [PlaneacionesController::class, 'crear'])->name('planeaciones.crear-planeacion');
Route::get('/planeacion/{id}/editar', [PlaneacionesController::class, 'editar'])->name('planeaciones.editar-planeacion');
Route::get('/planeacion/{id}/auditorias', [PlaneacionesController::class, 'planeacionAuditorias'])->name('planeaciones.planeacion.auditorias');
Route::get('/planeacion/{id}/registro', [PlaneacionesController::class, 'planeacionRegistro'])->name('planeaciones.planeacion.registro');

Route::get('/planeacion/{id}/auditorias/crear', [PlaneacionesController::class, 'planeacionAuditoriaCrear'])->name('planeaciones.planeacion.auditoria.crear');
Route::get('/planeacion/auditoria/{id}/editar', [PlaneacionesController::class, 'planeacionAuditoriaEditar'])->name('planeaciones.planeacion.auditoria.editar');
Route::get('/planeacion/auditoria/{id}/mensual', [PlaneacionesController::class, 'planeacionAuditoriaMensual'])->name('planeaciones.planeacion.auditoria.mensual');


Route::post('/planeacion/crear', [PlaneacionesController::class, 'create'])->name('planeaciones.planeacion.create');
Route::post('/planeacion/eliminar', [PlaneacionesController::class, 'delete'])->name('planeaciones.planeacion.delete');
Route::post('/planeacion/auditoria/crear', [PlaneacionesController::class, 'createAuditoria'])->name('planeaciones.planeacion.auditoria.create');
Route::post('/planeacion/auditoria/mensual', [PlaneacionesController::class, 'createAuditoriaMeses'])->name('planeaciones.planeacion.auditoria.mensual.create');
Route::post('/planeacion/auditoria/eliminar', [PlaneacionesController::class, 'deleteAuditoria'])->name('planeaciones.planeacion.auditoria.delete');
Route::post('/planeacion/auditoria/validate', [PlaneacionesController::class, 'validateAuditoria'])->name('planeaciones.planeacion.auditoria.validate');
