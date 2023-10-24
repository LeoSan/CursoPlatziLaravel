<?php

use App\Http\Controllers\DenunciaController;
use Illuminate\Support\Facades\Route;

//Formulario Denuciante
    Route::get('/registrar-denuncia/{param?}', [DenunciaController::class, 'showFormulario'])->name('registro');
    Route::get('/test-fecha', [DenunciaController::class, 'testFecha'])->name('testfecha');


Route::middleware('auth')->name('denuncias.')->group(function() {

        //Permiso Usuario Denunciante
        Route::get('/{id}/informacion-adicional/', [DenunciaController::class, 'showInformacionAdicional'])->name('informacion.adicional');
        Route::post('/informacion-actualizar', [DenunciaController::class, 'storeInformacionAdicional'])->name('actualizar');

        //Permiso Consultar Denuncias
        Route::group(['middleware' => ['permission:gestionar_denuncias|consultar_denuncias']], function () {
            Route::get('/bandeja/', [DenunciaController::class, 'index'])->name('index');
            Route::get('/{id}/detalle/', [DenunciaController::class, 'showDetalle'])->name('detalle');
            Route::get('/detalle/informe/{id}/crear', [DenunciaController::class, 'cargarInforme'])->name('informe.crear');
            Route::get('/detalle/informe/{id}/comentar', [DenunciaController::class, 'comentarInforme'])->name('informe.comentarios');
            Route::post('/informe', [DenunciaController::class, 'createInforme'])->name('informe.procesar');
            Route::post('/informe/editar', [DenunciaController::class, 'updateInforme'])->name('informe.actualizar');
            Route::post('/informe/comentar', [DenunciaController::class, 'commentInforme'])->name('informe.comentar');
        });

        //Permiso Alta Denuncia
        Route::group(['middleware' => ['permission:gestionar_denuncias|ejecutar_alta_denuncia']], function () {
            Route::get('/{id}/alta/',[DenunciaController::class,'showAlta'])->name('form.alta');
            Route::post('/alta', [DenunciaController::class, 'storeAltaDenuncia'])->name('guardar.alta');
        });
        //Permiso Providencia
        Route::group(['middleware' => ['permission:gestionar_denuncias|ejecutar_providencia']], function () {
            Route::get('/{id}/providencia/',[DenunciaController::class,'showProvidencia'])->name('form.providencia');
            Route::post('/providencia', [DenunciaController::class, 'storeProvidencia'])->name('guardar.providencia');
        });
        //Permiso Solicitar Expediente
        Route::group(['middleware' => ['permission:gestionar_denuncias|ejecutar_solicitud_exp']], function () {
            Route::get('/{id}/solicitar/expediente/',[DenunciaController::class,'showSolicitarExpediente'])->name('form.solicitar.expediente');
            Route::post('/procesar/solicitar-expediente/',[DenunciaController::class,'storeSolicitarExpediente'])->name('guardar.solicitar.expediente');
        });

        //Permiso Desestimar
        Route::group(['middleware' => ['permission:gestionar_denuncias|ejecutar_desestimar']], function () {
            Route::get('{id}/desestimar', [DenunciaController::class, 'desestimar'])->name('desestimar');
            Route::post('desestimacion', [DenunciaController::class, 'desestimacion'])->name('desestimacion');
        });
        //Permiso Admision
        Route::group(['middleware' => ['permission:gestionar_denuncias|admitir_denuncias']], function () {
            Route::get('{id}/admision', [DenunciaController::class, 'showAdmision'])->name('showAdmision');
            Route::post('storeAdmision', [DenunciaController::class, 'storeAdmision'])->name('storeAdmision');
        });
        //Bandeja para solicitud de expediente
        Route::group(['middleware' => ['permission:consultar_denuncias|ver_limitada_bandeja_denuncias']], function () {
            Route::get('/{id}/detalle_denuncia/', [DenunciaController::class, 'showDenunciaLimitada'])->name('detalleDenunciaLimitada');
            Route::post('/guardar_respuesta_solicitud_expediente',[DenunciaController::class,'storeRespuestaSolicitudExpediente'])->name('store_respuesta_solitud_expediente');
        });

        //Inadmision
        Route::group(['middleware' => ['permission:gestionar_denuncias']], function () {
            Route::get('/inadmision/{id}',[DenunciaController::class,'showInadmision'])->name('mostrar_inadmision');
            Route::post('/guardar_inadmision',[DenunciaController::class,'storeInadmision'])->name('guardar_inadmision');
            Route::get('/inadmision_no_procede/{id}',[DenunciaController::class,'noProcedeInadmision'])->name('no_procede_inadmision');
        });

        //Finaliza denuncia
        Route::group(['middleware' => ['permission:gestionar_denuncias']], function () {
            Route::get('/{id}/finaliza',[DenunciaController::class,'showFinaliza'])->name('form.finaliza');
            Route::post('/finalizacion',[DenunciaController::class,'storeFinaliza'])->name('guardar.finalizacion');
        });

        //Reasignación del auditor
        Route::group(['middleware' => ['permission:gestionar_denuncias']], function () {
            Route::get('/{id}/reasignar-auditor',[DenunciaController::class,'showReasignarAuditor'])->name('form.reasignar.auditor');
            Route::post('/reasignar-auditor',[DenunciaController::class,'storeReasignarAuditor'])->name('guardar.reasignar.auditor');
        });

    });
