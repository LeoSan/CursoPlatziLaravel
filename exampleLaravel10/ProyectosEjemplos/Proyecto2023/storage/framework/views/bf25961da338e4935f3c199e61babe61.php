<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginal2dcae471fc830b49206a12c6366ce5d7 = $component; } ?>
<?php $component = App\View\Components\BreadCrumbs::resolve(['itemsbread' => $itemsbread] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('bread-crumbs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\BreadCrumbs::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2dcae471fc830b49206a12c6366ce5d7)): ?>
<?php $component = $__componentOriginal2dcae471fc830b49206a12c6366ce5d7; ?>
<?php unset($__componentOriginal2dcae471fc830b49206a12c6366ce5d7); ?>
<?php endif; ?>
<?php echo $__env->make('denuncias.partials.modal-confirm', [ 'denuncia'=>$denuncia,'id_boton'=>'btnModalSolicitudExpediente', 'msj_confirm'=>'Al solicitar el expediente se asume que no se realizará una providencia, por lo cual no podrá realizarla más adelante ¿Desea continuar?', 'nomBoton'=>'Continuar', 'accion'=>'modalSolicitarExpediente'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="container  detalle-denuncia px-0">
    <div class="row mb-3">
        <div class="col d-flex">
            <div class="title-principal">Denuncia <?php echo e($denuncia->folio); ?></div>
            <div class="d-flex flex-row">
                <div> &nbsp; | &nbsp;</div>
                <div class="icon-status bg-estatus-<?php echo e($denuncia->estatus->codigo); ?>"></div>
                <div class="text-estatus-<?php echo e($denuncia->estatus->codigo); ?> fw-bolder" ><?php echo e($denuncia->estatus->nombre); ?></div>
            </div>
        </div>
    </div>
    
    <div class="accordion rounded-0 border-0" id="accordionDetalle">
        <div class="accordion-item rounded-0 mb-2 border-0">
            <h2 class="accordion-header" id="headingOne">
              <button class="accordion-button collapsed titulo-bg-gray text-gray fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                    <svg width="19" height="19" viewBox="0 0 19 19" xmlns="http://www.w3.org/2000/svg" >
                        <path d="M9.5 0C4.262 0 0 4.262 0 9.5S4.262 19 9.5 19 19 14.738 19 9.5 14.738 0 9.5 0zm1.583 15.438a.396.396 0 0 1-.396.395H8.313a.396.396 0 0 1-.396-.396V9.5H7.52a.396.396 0 0 1-.396-.396V7.521c0-.219.177-.396.396-.396h3.167c.218 0 .395.177.395.396v7.917zM9.5 6.332c-.873 0-1.583-.71-1.583-1.583s.71-1.583 1.583-1.583 1.583.71 1.583 1.583-.71 1.583-1.583 1.583z" fill="#555770" fill-rule="nonzero"/>
                    </svg>
                    <span class="px-2">
                        Información general
                    </span>
              </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse <?php if($denuncia->estatus->codigo == 'pendiente'): ?> <?php echo e('show'); ?> <?php endif; ?>" aria-labelledby="headingOne" data-bs-parent="#accordionDetalle">
                <div class="accordion-body bg-white">
                    
                    <?php echo $__env->make('denuncias.fragmentos.info-datos-denuncia', ['denuncia' => $denuncia, 'documento'=>$documento], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    
                    <?php echo $__env->make('denuncias.fragmentos.info-pruebas-denuncia', ['doc_list' => $doc_evidencias_denuncia,'denuncia' => $denuncia, 'col'=>'row'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>

        <?php if($denuncia->estatus->codigo == 'en_revision' || $denuncia->hasEstatus('en_revision')): ?>
        <div class="accordion-item rounded-0 mb-2 border-0">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed titulo-bg-gray text-gray fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    <svg width="16" height="13" viewBox="0 0 16 13" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.711 1.693 14.307.289A.955.955 0 0 0 13.605 0a.955.955 0 0 0-.702.289L6.132 7.071 3.097 4.026a.955.955 0 0 0-.702-.29.956.956 0 0 0-.702.29L.289 5.43A.956.956 0 0 0 0 6.132c0 .275.096.509.289.702l3.737 3.736 1.404 1.404a.955.955 0 0 0 .702.29c.275 0 .509-.097.702-.29l1.403-1.404 7.474-7.473A.956.956 0 0 0 16 2.395a.956.956 0 0 0-.289-.702z" fill="#555770" fill-rule="nonzero"/>
                    </svg>
                    <span class="px-2">
                        Alta de la denuncia
                    </span>
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse  <?php if($denuncia->estatus_id == obtenerIdCatalogoElementCodigo('en_revision') ): ?> <?php echo e('show'); ?> <?php endif; ?>" aria-labelledby="headingTwo" data-bs-parent="#accordionDetalle">
                <div class="accordion-body bg-white">
                    
                    <?php echo $__env->make('denuncias.fragmentos.info-alta-denuncia', ['denuncia' => $denuncia, 'doc_alta_denun'=>$doc_alta_denun], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if($denuncia->estatus->codigo == 'solventado' || $denuncia->hasEstatus('solventado')): ?>
        <div class="accordion-item rounded-0 mb-2 border-0">
            <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed titulo-bg-gray text-gray fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    <svg width="20" height="17" viewBox="0 0 20 17" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.482 16.786a.696.696 0 0 1-.696-.695v-2.433c0-.383.312-.694.696-.695h11.17a3.304 3.304 0 0 0 3.306-3.301A3.304 3.304 0 0 0 12.65 6.36H9.65l.493 1.398a.694.694 0 0 1-1.1.767L4.75 4.985a.717.717 0 0 1 0-1.072L9.043.373a.697.697 0 0 1 1.1.767L9.65 2.538h3.001c3.94 0 7.135 3.19 7.135 7.124 0 3.934-3.194 7.124-7.135 7.124H1.482z" fill="#555770" fill-rule="nonzero"/>
                    </svg>

                    <span class="px-2">
                        Providencia
                    </span>
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse <?php echo e($denuncia->estatus->codigo=='solventado' ? 'show' : ''); ?>" aria-labelledby="headingThree" data-bs-parent="#accordionDetalle">
                <div class="accordion-body bg-white">
                    
                    <?php echo $__env->make('denuncias.fragmentos.info-providencia', ['denuncia' => $denuncia, 'doc_providencia_denuncia'=>$doc_providencia_denuncia, 'col'=>'col-12'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if( $denuncia->estatus->codigo=='solicitud_expediente' || $denuncia->hasEstatus('solicitud_expediente') ): ?>
        <div class="accordion-item rounded-0 mb-2 border-0">
            <h2 class="accordion-header" id="headingFour">
                <button class="accordion-button collapsed titulo-bg-gray text-gray fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                    <svg width="19" height="15" viewBox="0 0 19 15" xmlns="http://www.w3.org/2000/svg">
                        <g fill="#555770" fill-rule="nonzero">
                            <path d="M2.111 14.266H16.89c1.161 0 2.111-.95 2.111-2.111V6.65H0v5.505c0 1.16.95 2.11 2.111 2.11zM19 4.443c0-1.161-.95-2.111-2.111-2.111h-8.88v-.22C8.009.95 7.059 0 5.898 0H2.11C.95 0 0 .95 0 2.111V4.961h19v-.518z"/>
                        </g>
                    </svg>
                    <span class="px-2">
                        Solicitud del expediente
                    </span>
                </button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse <?php if( $denuncia->estatus->codigo == 'solicitud_expediente' ||  $denuncia->estatus->codigo == 'expediente_recibido' || $denuncia->estatus->codigo == 'povidencia'): ?> <?php echo e('show'); ?>  <?php endif; ?>" aria-labelledby="headingFour" data-bs-parent="#accordionDetalle">
                <div class="accordion-body bg-white">
                    
                    <?php echo $__env->make('denuncias.fragmentos.info-solicitud-expediente', ['denuncia' => $denuncia, 'doc_solicitar_expe'=>$doc_solicitar_expe, 'col'=>'col-12'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>
        <?php endif; ?>


        <?php if($denuncia->estatus->codigo=='desestimado' || $denuncia->hasEstatus('desestimado')): ?>
            <div class="accordion-item rounded-0 mb-2 border-0">
                <h2 class="accordion-header" id="headigDesestimacion">
                    <button class="accordion-button collapsed titulo-bg-gray text-gray fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDesestimacion" aria-expanded="false" aria-controls="collapseDesestimacion">
                        <svg width="22" height="20" viewBox="0 0 22 20" xmlns="http://www.w3.org/2000/svg">
                            <g fill="#555770" fill-rule="nonzero">
                                <path d="M8.258 11.371h-4.47a.75.75 0 0 1-.758-.757c0-.417.334-.758.758-.758h3.576a7.624 7.624 0 0 1-.5-1.432H3.788a.755.755 0 0 1-.758-.757c0-.417.334-.758.758-.758h2.856c-.008-.129-.008-.25-.008-.379 0-.901.152-1.765.425-2.575H2.727A2.73 2.73 0 0 0 0 6.682v7.863a2.72 2.72 0 0 0 2.44 2.705v1.598A1.147 1.147 0 0 0 3.59 20c.258 0 .508-.083.713-.25l1.705-1.34a5.296 5.296 0 0 1 3.28-1.145h5.242c1.5 0 2.728-1.22 2.728-2.72v-.393a8.036 8.036 0 0 1-9-2.78zm.37 2.955h-4.84a.755.755 0 0 1-.758-.758c0-.416.334-.757.758-.757h4.84a.76.76 0 0 1 .758.757.76.76 0 0 1-.757.758z"/>
                                <path d="M14.674 0c3.599 0 6.53 2.932 6.53 6.53a6.536 6.536 0 0 1-6.53 6.53 6.531 6.531 0 0 1-6.53-6.53A6.536 6.536 0 0 1 14.674 0zm1.296 4.356c-.099 0-.185.036-.257.109l-1.035 1.034-1.035-1.034a.352.352 0 0 0-.257-.109.358.358 0 0 0-.263.109l-.514.514a.358.358 0 0 0-.109.263c0 .1.036.185.109.257l1.034 1.035L12.61 7.57a.352.352 0 0 0-.109.257c0 .103.036.19.109.263l.514.515c.073.072.16.108.263.108.1 0 .185-.036.257-.108l1.035-1.035 1.035 1.035a.352.352 0 0 0 .257.108c.103 0 .19-.036.263-.108l.515-.515a.358.358 0 0 0 .108-.263c0-.099-.036-.185-.108-.257l-1.035-1.035L16.748 5.5a.351.351 0 0 0 .108-.257.358.358 0 0 0-.108-.263l-.515-.514a.358.358 0 0 0-.263-.109z"/>
                            </g>
                        </svg>
                        <span class="px-2">
                        Desestimación
                        </span>
                    </button>
                </h2>
                <div id="collapseDesestimacion" class="accordion-collapse collapse <?php echo e($denuncia->estatus->codigo=='desestimado'?'show':''); ?>" aria-labelledby="headigDesestimacion" data-bs-parent="#accordionDetalle">
                    <div class="accordion-body bg-white">
                        <?php echo $__env->make('denuncias.fragmentos.info-desistimiento', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if($denuncia->estatus->codigo == 'inadmision' || $denuncia->estatus->codigo == 'revision_inadmision' || $denuncia->hasEstatus('inadmision') || $denuncia->hasEstatus('revision_inadmision') ): ?>
            <div class="accordion-item rounded-0 mb-2 border-0">
            <h2 class="accordion-header" id="headingFive">
              <button class="accordion-button collapsed titulo-bg-gray text-gray fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                    <svg width="18" height="22" viewBox="0 0 18 22" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.255 10.94c-1.282 1.961-3.641 5.623-5.028 8.118-1.66 2.986-5.003 2.947-5.156 2.941H5.107A5.113 5.113 0 0 1 0 16.892V5.107a1.179 1.179 0 0 1 2.357 0v6.285a.393.393 0 0 0 .786 0V2.357a1.179 1.179 0 0 1 2.357 0v9.035a.393.393 0 0 0 .786 0V1.18a1.179 1.179 0 0 1 2.357 0v10.213a.393.393 0 0 0 .785 0V3.536a1.179 1.179 0 0 1 2.357 0v8.872l-.727.728a.393.393 0 0 0 .555.555l3.491-3.491a1.742 1.742 0 0 1 1.71-.443.784.784 0 0 1 .443 1.184h-.002z" fill="#555770" fill-rule="nonzero"/>
                </svg>

                    <span class="px-2">
                        Inadmisión
                    </span>
              </button>
            </h2>
            <div id="collapseFive" class="accordion-collapse collapse  <?php if( $denuncia->estatus->codigo == 'inadmision' || $denuncia->estatus->codigo == 'revision_inadmision'): ?><?php echo e('show'); ?> <?php endif; ?>" aria-labelledby="headingFive" data-bs-parent="#accordionDetalle">
                <div class="accordion-body bg-white">
                    
                    <?php echo $__env->make('denuncias.fragmentos.info-inadmision', ['denuncia' => $denuncia, 'doc_oficio_inadmsion_denuncia'=>$doc_oficio_inadmsion_denuncia,'col'=>'col-12'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        
        <?php if( ($denuncia->estatus->codigo=='admitida' || $denuncia->hasEstatus('admitida'))  ): ?>
            <div class="accordion-item rounded-0 mb-2 border-0">
                <h2 class="accordion-header" id="headingAdmision">
                    <button class="accordion-button collapsed titulo-bg-gray text-gray fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdmision" aria-expanded="false" aria-controls="collapseAdmision">
                        <svg width="19" height="15" viewBox="0 0 19 15" xmlns="http://www.w3.org/2000/svg">
                            <g fill="#555770" fill-rule="nonzero">
                                <path d="M2.111 14.266H16.89c1.161 0 2.111-.95 2.111-2.111V6.65H0v5.505c0 1.16.95 2.11 2.111 2.11zM19 4.443c0-1.161-.95-2.111-2.111-2.111h-8.88v-.22C8.009.95 7.059 0 5.898 0H2.11C.95 0 0 .95 0 2.111V4.961h19v-.518z"/>
                            </g>
                        </svg>
                        <span class="px-2">
                            Admisión
                        </span>
                    </button>
                </h2>
                <div id="collapseAdmision" class="accordion-collapse collapse <?php echo e($denuncia->estatus->codigo=='admitida'?'show':''); ?> " aria-labelledby="headingAdmision" data-bs-parent="#accordionDetalle">
                    <div class="accordion-body bg-white">
                        
                        <?php echo $__env->make('denuncias.fragmentos.info-admision', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if($denuncia->informe): ?>
            <div class="accordion-item rounded-0 mb-2 border-0">
                <h2 class="accordion-header" id="headingInformes">
                    <button class="accordion-button titulo-bg-gray text-gray fw-semibold text-gray fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInformes" aria-expanded="false" aria-controls="collapseInformes">
                        <svg width="17" height="20" viewBox="0 0 17 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.16 0H2.84A2.843 2.843 0 0 0 0 2.84v13.85a2.848 2.848 0 0 0 2.84 2.841h11.32a2.848 2.848 0 0 0 2.84-2.84V2.84C17 1.27 15.722 0 14.16 0zM8.456 16.552h-3.88a.879.879 0 1 1 0-1.758h3.88a.878.878 0 1 1 0 1.758zm3.967-4.199H4.576a.879.879 0 1 1 0-1.757h7.847a.879.879 0 1 1 0 1.757zm1.166-7.913L10.77 7.582a.881.881 0 0 1-1.127.154L6.908 5.992l-2.21 2.306a.878.878 0 1 1-1.269-1.215l2.71-2.828a.88.88 0 0 1 1.106-.133L9.96 5.853l2.321-2.587A.878.878 0 1 1 13.59 4.44z" fill="#555770" fill-rule="nonzero"/>
                        </svg>
                        <span class="px-2">
                            Informes
                        </span>
                    </button>
                </h2>
                <div id="collapseInformes" class="accordion-collapse collapse <?php echo e(($denuncia->estatus->codigo == 'validar_informe_auditor' || $denuncia->estatus->codigo == 'informe_actualizado' || $denuncia->estatus->codigo == 'informe_cargado' || $denuncia->estatus->codigo == 'observaciones_informe' || $denuncia->estatus->codigo == 'finalizado') ? 'show' : ''); ?> " aria-labelledby="headingInformes" data-bs-parent="#accordionDetalle">
                    <div class="accordion-body bg-white">
                        
                        <?php echo $__env->make('denuncias.fragmentos.informe', ['informe' => $denuncia->informe, 'doc_informe_final'=>$doc_informe_final, 'doc_acuse_recibo_informe_final_denuncia'=>$doc_acuse_recibo_informe_final_denuncia], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        

            <!-- BOTONES -->
            <div class="row mt-4 justify-content-end">
                <div class="form-group col-md-3 mb-2 mb-md-0 d-flex  justify-content-end px-2">
                    <a href="<?php echo e(session('url_back_bandeja_denuncia')); ?>" class="btn btn-accion-detalle btn-default w-100">
                        Cancelar
                    </a>
                </div>
                <?php if($denuncia->usuario_asignado_id == auth()->id() ||  Auth::user()->can('gestionar_denuncias')): ?>

                    <?php if(!in_array($denuncia->estatus->codigo, ['inadmision', 'finalizado', 'desestimado'])): ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ejecutar_reasignar_auditor')): ?>
                            <?php echo $__env->make('denuncias.botones.acciones-st-reasignar-auditor', ['denuncia' => $denuncia], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php switch($denuncia->estatus->codigo):
                        case ('pendiente'): ?>

                            <?php echo $__env->make('denuncias.botones.acciones-st-pendientes', ['denuncia' => $denuncia], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php break; ?>
                        <?php case ('en_revision'): ?>

                            <?php echo $__env->make('denuncias.botones.acciones-st-revision', ['denuncia' => $denuncia], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php break; ?>
                        <?php case ('solventado'): ?>

                            <?php echo $__env->make('denuncias.botones.acciones-st-solventado', ['denuncia' => $denuncia], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php break; ?>
                        <?php case ('revision_inadmision'): ?>

                            <?php echo $__env->make('denuncias.botones.acciones-st-revision-inadmision', ['denuncia' => $denuncia], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php break; ?>
                        <?php case ('expediente_recibido'): ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admitir_denuncias')): ?>
                                <div class="form-group col-md-3 mb-2 mb-md-0 d-flex  justify-content-end">
                                    <a class="btn btn-accion-detalle bg-btn-guardar w-100" href="<?php echo e(route('denuncias.showAdmision',$denuncia->id)); ?>">Admitir</a>
                                </div>
                            <?php endif; ?>
                        <?php break; ?>
                        <?php case ('admitida'): ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cargar_informe_denuncia')): ?>
                                <div class="form-group col-md-3 mb-2 mb-md-0 d-flex  justify-content-end">
                                    <a class="btn btn-accion-detalle btn-success text-white w-100"
                                       href="<?php echo e(route('denuncias.informe.crear',$denuncia->id)); ?>">
                                        Cargar informe
                                    </a>
                                </div>
                            <?php endif; ?>
                        <?php break; ?>
                        <?php case ('observaciones_informe'): ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cargar_informe_denuncia')): ?>
                                <div class="form-group col-md-3 mb-2 mb-md-0 d-flex  justify-content-end">
                                    <a class="btn btn-accion-detalle bg-btn-reasignar-auditor text-white w-100"
                                       href="<?php echo e(route('denuncias.informe.crear',$denuncia->id)); ?>">
                                        Atender comentarios
                                    </a>
                                </div>
                            <?php endif; ?>
                        <?php break; ?>
                    <?php endswitch; ?>
                <?php endif; ?>


                <?php switch($denuncia->estatus->codigo):
                    case ('validar_informe_auditor'): ?>
                    <?php case ('informe_cargado'): ?>
                    <?php case ('informe_actualizado'): ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('comentar_informe_denuncia')): ?>
                            <div class="form-group col-md-3 mb-2 mb-md-0 d-flex  justify-content-end">
                                <a class="btn btn-accion-detalle bg-btn-reasignar-auditor text-white w-100"
                                   href="<?php echo e(route('denuncias.informe.comentarios',$denuncia->id)); ?>">
                                    Comentar informe
                                </a>
                            </div>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ejecutar_finalizacion')): ?>
                            <div class="form-group col-md-3 mb-2 mb-md-0 d-flex  justify-content-end">
                                <a class="btn btn-accion-detalle bg-btn-guardar text-white w-100"
                                   href="<?php echo e(route('denuncias.form.finaliza',$denuncia->id)); ?>">
                                    Finalizar
                                </a>
                            </div>
                        <?php endif; ?>
                        <?php break; ?>
                <?php endswitch; ?>
            </div>


    </div>


</div>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sglle-honduras\resources\views/denuncias/detalle.blade.php ENDPATH**/ ?>