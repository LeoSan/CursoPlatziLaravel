<?php

use App\Http\Controllers\AuditoriasController;
use Illuminate\Support\Facades\Route;

    Route::prefix('ejecucion')->name('auditorias.')->group(function () {
        Route::get('/', [AuditoriasController::class, 'index'])->name('ejecuciones');
        Route::get('/seguimiento', [AuditoriasController::class, 'showSeguimiento'])->name('seguimiento');


        Route::prefix('{ejecucion}/detalle')->name('ejecucion.')->group(function () {
            Route::get('/informacion', [AuditoriasController::class, 'detalle'])->name('detalle');
        });

        Route::prefix('{ejecucion}/proceso')->name('ejecucion.proceso.')->group(function () {
            Route::get('/lista-verificacion', [AuditoriasController::class, 'ejecucionLista'])->name('lista');
            Route::post('/lista-verificacion', [AuditoriasController::class, 'storeEjecucionLista'])->name('storeLista');
            Route::get('/cedulas-trabajo', [AuditoriasController::class, 'ejecucionCedulas'])->name('cedulas');
            Route::get('/resultados-preliminares', [AuditoriasController::class, 'ejecucionResultados'])->name('resultados');
            Route::get('/acta-cierre', [AuditoriasController::class, 'ejecucionCierre'])->name('cierre');
        });

        Route::post('/cierre', [AuditoriasController::class, 'cierreProceso'])->name('ejecucion.proceso.finalizar');
        Route::post('/reasignacion', [AuditoriasController::class, 'reasignacion'])->name('ejecucion.reasignacion');
        Route::post('/finalizar-sin-ejecutar', [AuditoriasController::class, 'finalizarSinEjecutar'])->name('ejecucion.proceso.finalizar-sin-ejecutar');

        Route::post('/store-plantilla', [AuditoriasController::class, 'storePlantilla'])->name('store.plantilla');
        Route::post('/delete-plantilla', [AuditoriasController::class, 'deletePlantilla'])->name('delete.plantilla');
        Route::post('/store-plantilla-firma', [AuditoriasController::class, 'storePlantillaFirma'])->name('store.plantilla.firma');
        Route::post('/delete-plantilla-firma', [AuditoriasController::class, 'deletePlantillaFirma'])->name('delete.plantilla.firma');
        Route::get('/plantilla-pdf/{id}', [AuditoriasController::class, 'plantillaPdf'])->name('plantilla.pdf');
        Route::get('/plantilla-doc/{id}', [AuditoriasController::class, 'plantillaDoc'])->name('plantilla.doc');
        Route::prefix('{ejecucion}/informe')->name('ejecucion.informe.')->group(function () {
            Route::get('/auditoria', [AuditoriasController::class, 'showElaboracionInformeAuditoria'])->name('auditoria');

        });
        Route::post('/store-informe-auditoria', [AuditoriasController::class, 'storeElaboracionInformeAuditoriaEjecutada'])->name('store.informe-auditoria');

        Route::group(['middleware' => ['permission:incumplimiento_auditorias']], function () {
            Route::get('/{ejecucion}/incumplimiento', [AuditoriasController::class, 'showIncumplimiento'])->name('showIncumplimiento');
            Route::post('/incumplimiento', [AuditoriasController::class, 'storeIncumplimiento'])->name('storeIncumplimiento');
            Route::get('/{ejecucion}/iniciarProceso', [AuditoriasController::class, 'showIniciarProceso'])->name('showIniciarProceso');
            Route::post('/iniciarProceso', [AuditoriasController::class, 'storeIniciarProceso'])->name('storeIniciarProceso');
        });

    });

    Route::prefix('seguimiento')->name('auditoria.')->group(function () {
        Route::get('/carga-documento/{ejecucion}', [AuditoriasController::class, 'showCargaDocumento'])->name('seguimiento.informe');
        Route::post('/registrar/carga-documento', [AuditoriasController::class, 'storeCargaDocumento'])->name('registrar.informe');
    });

    //Solicitud Expdientes
    Route::group(['middleware' => ['permission:gestion_auditorias|solicitud_expediente|respuesta_solicitud_expediente']], function () {
        Route::prefix('expedientes')->name('auditorias.')->group(function () {
            Route::get('/solicitar', [AuditoriasController::class, 'showSolictudExpedientes'])->name('listado.solicitar.expediente');
            Route::get('/solicitar/expedientes', [AuditoriasController::class, 'showFormSolictudExpedientes'])->name('formulario.solicitud.expediente');
            Route::post('/solicitar/registro/expedientes', [AuditoriasController::class, 'storeSolictudExpedientes'])->name('registrar.solicitud.expediente');
            Route::get('/incumplimiento/levantar-acta/{id}', [AuditoriasController::class, 'showLevantarActa'])->name('levantar.acta');
            Route::post('/incumplimiento/registro-acta', [AuditoriasController::class, 'storeLevantarActa'])->name('registrar.acta.incumplimiento');
            Route::get('{id}/expediente/detalle', [AuditoriasController::class, 'showDetalleSolicitud'])->name('detalle.expediente');
            Route::get('/solicitud_expedientes/detalle/{expediente_id}', [AuditoriasController::class, 'solicitudExpedienteDetalle'])->name('solicitud_expediente.detalle');
            Route::post('/solicitud_expedientes/respuesta', [AuditoriasController::class, 'storeRespuestaSolictudExpedientes'])->name('respuesta.solicitud.expediente');
        });
    });
    //Respuesta a solicitud de expediente a jefes regionales
    Route::group(['middleware' => ['permission:respuesta_solicitud_expediente']], function () {

    });
    //Incumplimiento de auditoría
    //Prorroga solicitud expedientes
    Route::group(['middleware' => ['permission:prorroga_solicitud_expedientes']], function () {
        Route::get('/{ejecucion}/prorroga', [AuditoriasController::class, 'showProrroga'])->name('auditorias.showProrroga');
        Route::post('/registrar/prorroga', [AuditoriasController::class, 'storeProrroga'])->name('auditorias.storeProrroga');
    });
