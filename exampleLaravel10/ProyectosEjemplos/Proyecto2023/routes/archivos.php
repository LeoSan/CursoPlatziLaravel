<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{ArchivosController,
    CasoController,
    BitacoraController,
    HomeController,
    CatalogoController,
    DenunciaController,
    ResolucionController};


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
Route::get('descarga/{carpeta}/{dependencia_id}/{tipo_entidad}/{entidad_id}/{tipo_documento}/{archivo}',[ArchivosController::class,'descarga'])->name('archivos.descarga');
Route::post('eliminar',[ArchivosController::class,'eliminar'])->name('archivos.eliminar');
