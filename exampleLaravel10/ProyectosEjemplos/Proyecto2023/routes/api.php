<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('getMunicipiosByDepartamentoId',[ApiController::class,'getMunicipiosByDepartamentoId']);
Route::post('getInfraccionesByAnio',[ApiController::class,'getInfraccionesByAnio']);
Route::post('sendDataDenuncia',[ApiController::class,'sendDataDenuncia']);
Route::post('getOficinaRegionalByMunicipiosId',[ApiController::class,'getOficinaRegionalByMunicipiosId']);

Route::post('obtenerSolicitudRegionMes',[ApiController::class,'obtenerSolicitudRegionMes']);
Route::post('obtenerJefeRegional',[ApiController::class,'obtenerJefeRegional']);
