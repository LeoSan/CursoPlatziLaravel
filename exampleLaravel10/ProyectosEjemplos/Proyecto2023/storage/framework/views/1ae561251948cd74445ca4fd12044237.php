<?php $__env->startSection('content'); ?>

    <div class="container">

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

        <div class="d-flex mb-2 align-items-center mb-4">
            <div class="form-group">
                <h5 class="fw-semibold m-0 p-0 ">
                    Denuncia <?php echo e($denuncia->folio); ?>

                </h5>
            </div>
            <div class="form-group">
                <div class="fw-normal text-graylight d-none d-md-inline px-2">|</div>
            </div>
            <div class="form-group">
                <?php echo $__env->make('partials.estatus', ['estatus' => $denuncia->estatus], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>

        <div class="card bg-white">
            <div class="card-header fw-semibold fs-5">
                <small>
                    Comentar informe de denuncia
                </small>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('denuncias.informe.comentar')); ?>" method="post" class="d-block pb-4 necesita-validacion" onsubmit="validarFormulario()" novalidate enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="denuncia" value="<?php echo e($denuncia->id); ?>">
                    <input type="hidden" name="informe" value="<?php echo e($informe->id); ?>">

                    <div class="bg-white px-1 py-2">
                        <div class="row mb-1">
                            <?php if($informe->documentos?->count()): ?>
                                <?php $__currentLoopData = $informe->documentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $documento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="mb-3 col-sm-8 col-md-6 col-lg-4 col-xl-3">
                                        <h5 class="fw-bold font-small-size">Documento</h5>
                                        <div
                                            class=" d-flex btn-file py-3 px-3 text-decoration-none rounded-2 mt-2">
                                            <div class="d-flex w-100 justify-content-between align-items-center">
                                                <div class="d-inline">
                                                    <div class="d-inline">
                                                        <a href="<?php echo e(url('archivos/descarga/'.$documento->ruta)); ?>"
                                                           class="enlace"><?php echo e($documento->descripcion); ?>

                                                            <svg class="m-1" width="21" height="21" viewBox="0 0 21 21"
                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M10.5 11.25h3.75v2.25H10.5v-2.25zM9 10.5a.75.75 0 0 1 .75-.75h4.5V7.5h-7.5v6H9v-3zm12 0C21 16.29 16.29 21 10.5 21S0 16.29 0 10.5 4.71 0 10.5 0 21 4.71 21 10.5zm-5.25-3.75A.75.75 0 0 0 15 6H6a.75.75 0 0 0-.75.75v7.5c0 .414.335.75.75.75h9a.75.75 0 0 0 .75-.75v-7.5z"
                                                                    fill="#1C1C28" fill-rule="nonzero"/>
                                                            </svg>
                                                            <span class="d-flex fw-bold f-10"><?php echo e($documento->nombre); ?></span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>

                        <div class="item mb-4">
                            <div class="">
                                <?php if($informe->visita_campo): ?>
                                    <i class="fa-solid fa-check text-success fs-6 me-1"></i>
                                <?php else: ?>
                                    <i class="fa-solid fa-xmark text-danger fs-6 me-1"></i>
                                <?php endif; ?>
                                <span class="fw-bold font-small-size">
                            Se realizó visita en campo
                        </span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h5 class="fw-bold font-small-size">
                                Observaciones
                            </h5>
                            <div class="mb-4 font-regular-size">
                                <?php if($informe->observaciones): ?>
                                    <?php echo $informe->observaciones; ?>

                                <?php else: ?>
                                    Dato no proporcionado
                                <?php endif; ?>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="form-group col-md-12 mb-4">
                                <label class="form-label" for="comentarios">Comentarios *</label>
                                <textarea type="text" name="comentarios" class="form-control font-regular-size editor"
                                          rows="7" maxlength="1700" id="comentarios" required
                                          placeholder="Escriba las observaciones"></textarea>
                                <div class="invalid-feedback">Este campo debe tener máximo 1700 caracteres.</div>
                            </div>
                        </div>


                    </div>

                    <div class="mt-4 d-flex seccion-acciones w-100 justify-content-end gap-2 gap-md-3 flex-wrap flex-md-nowrap">
                        <div class="form-group mb-2 mb-md-0 w-100">
                            <a class="btn btn-accion-detalle btn-default w-100" href="<?php echo e(route('denuncias.detalle', ['id' => $denuncia->id])); ?>">
                                Cancelar
                            </a>
                        </div>
                        <div class="form-group mb-2 mb-md-0 w-100">
                            <button type="submit" class="btn btn-accion-detalle btn-success w-100">
                                <span class="">Enviar comentarios</span>
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>


    </div>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sglle-honduras\resources\views/denuncias/informe-comentar.blade.php ENDPATH**/ ?>