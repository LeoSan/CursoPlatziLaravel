<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{HomeController, PlantillaController};


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes(['register'=>false]);

Route::middleware(['guest'])->get('/', function () {
    return view('auth.login');
})->name('login');

Route::get('/', [HomeController::class, 'index'])->name('index');

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/files', [HomeController::class, 'files'])->name('files');
Route::post('/load-files', [HomeController::class, 'load'])->name('load');

Route::get('cuenta/password', [App\Http\Controllers\CuentaController::class, 'password'])->name('cuenta.password');
Route::post('cuenta/password', [App\Http\Controllers\CuentaController::class, 'actualizarPassword'])->name('cuenta.actualizar.password');

Route::post('/archivos/store', 'App\Http\Controllers\ArchivosController@store')->name('archivos.store');

Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

Route::post('/sidebar-collapse', [HomeController::class, 'updateSidebarCollapse']);

Route::post('/getDiasInhabiles', [HomeController::class, 'getDiasInhabiles']);

Route::get('descargaPlantillaPdf/{plantilla}', [PlantillaController::class,'descargarPdf'])->name('plantillas.descargaPdf');
Route::get('descargaPlantillaDoc/{plantilla}', [PlantillaController::class,'descargarDoc'])->name('plantillas.descargaDoc');
