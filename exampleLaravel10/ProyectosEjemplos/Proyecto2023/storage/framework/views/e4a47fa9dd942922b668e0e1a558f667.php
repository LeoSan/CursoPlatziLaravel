<div class="bg-white pt-1">

    <h5 class="fw-bold text-danger fs-6 mb-2">
        Informe del auditor
    </h5>

    <div class="row mb-1">
        <?php if($informe->documentos?->count()): ?>
            <?php $__currentLoopData = $informe->documentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $documento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make('denuncias.fragmentos.documento', ['item' => $documento, 'doclabel' => 'Documento'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </div>

    <div class="item mb-4">
        <div class="fs-6">
            <?php if($informe->visita_campo): ?>
                <i class="fa-solid fa-check text-success fs-5 me-1"></i>
            <?php else: ?>
                <i class="fa-solid fa-xmark text-danger fs-5 me-1"></i>
            <?php endif; ?>
            <span class="fw-normal">
                Se realizó visita en campo
            </span>
        </div>
    </div>

    <div class="mb-4">
        <p class="fw-bold">
            Observaciones
        </p>
        <div class="mb-4 font-regular-size">
            <?php if($informe->observaciones): ?>
                <?php echo $informe->observaciones; ?>

            <?php else: ?>
                Dato no proporcionado
            <?php endif; ?>
        </div>
    </div>

    <?php if($informe->comentarios): ?>
        <hr class="border-light-gray">

        <div class="mb-4">
            <h5 class="fw-bold text-danger fs-6 mb-2">
                Comentarios
            </h5>
            <div class="mb-4 font-regular-size">
                <?php echo $informe->comentarios; ?>

            </div>
        </div>

        <?php if($informe->adjuntos?->count()): ?>
            <h5 class="fw-semibold fs-6">Adjuntos</h5>
            <div class="row mb-1">
                <?php $__currentLoopData = $informe->adjuntos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $documento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <?php echo $__env->make('denuncias.fragmentos.documento', ['item' => $documento], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>


    <?php $__empty_1 = true; $__currentLoopData = $denuncia->gestion_denuncia; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $items_gestion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php if($items_gestion->estatus_id == obtenerIdCatalogoElementCodigo('finalizado')): ?>
            <div class="mb-4">
                <div class="bg-border mb-3"></div>
                <div class="col-12 text-danger">
                    <h6 class="fw-bolder">Informe enviado al ministro</h6>
                </div>

                <div class="mb-4 font-regular-size">
                    <span class="mb-3">Fecha de entrega al ministro</span>
                    <p><?php echo e(formatoFecha($items_gestion->fecha_recepcion)); ?></p>
                </div>
                <?php if(isset($doc_informe_final->ruta)): ?>
                    <div class="row bg-white">

                        <?php echo $__env->make('denuncias.fragmentos.documento', ['item' => $doc_acuse_recibo_informe_final_denuncia], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        <?php echo $__env->make('denuncias.fragmentos.documento', ['item' => $doc_informe_final], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    </div>
                <?php endif; ?>
            </div>

        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <?php echo e(''); ?>

    <?php endif; ?>
</div>
<?php /**PATH C:\laragon\www\sglle-honduras\resources\views/denuncias/fragmentos/informe.blade.php ENDPATH**/ ?>