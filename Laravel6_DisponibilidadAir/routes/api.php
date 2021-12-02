<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\EventoPersonaController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\InhabilController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//
Route::post('eventos/crear',[EventoController::class,'storeEventos'])->name('api.guardarEventos');
Route::post('eventos/consulta',[EventoController::class,'getEventos'])->name('api.consulta');
Route::post('eventos/consultaReferencia',[EventoController::class,'getReferencia'])->name('api.consultaReferencia');
Route::post('eventos/consultaEvento',[EventoController::class,'getEvento'])->name('api.consultaEvento');
Route::post('eventos/consultaPorPersona',[EventoController::class,'getEventoPersonas'])->name('api.consultaPorPersona');
Route::post('eventos/asignar',[EventoPersonaController::class,'asignarEventos'])->name('api.asignarEventos');
Route::post('eventos/desasignar',[EventoPersonaController::class,'desasignarEventos'])->name('api.desasignarEventos');
//
Route::post('fechas/disponibilidadPersona',[PersonaController::class,'disponibilidad'])->name('api.disponibilidadPersona');
Route::post('fechas/asignarInhabil',[InhabilController::class,'store'])->name('api.asignarInhabil');
Route::post('fechas/editarInhabil',[InhabilController::class,'update'])->name('api.editarInhabil');
Route::post('fechas/eliminarInhabil',[InhabilController::class,'destroy'])->name('api.eliminarInhabil');

Route::post('fechas/persona/dias-inhabiles', [InhabilController::class, 'getPersonaIdDiasInhabiles'])->name('api.inhabil.persona');

Route::post('fechas/dias-inhabiles', [InhabilController::class, 'consultar'])->name('api.inhabil.consultar');

Route::post('personas/consulta',[PersonaController::class,'consulta'])->name('api.consultaPersonas');
Route::post('personas/consultaFechaZona',[PersonaController::class,'consultaFechaZona'])->name('api.consultaPersonasFechaZona');
Route::post('personas/consultaPeriodoZonas',[PersonaController::class,'consultaPeriodoZonas'])->name('api.consultaPeriodoZonas');

/**
 * Dia Inhabil
 */




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

