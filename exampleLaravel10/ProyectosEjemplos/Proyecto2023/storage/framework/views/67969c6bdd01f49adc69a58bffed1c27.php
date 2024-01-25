    <?php $__empty_1 = true; $__currentLoopData = $denuncia->gestion_denuncia; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $items_pro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php if( $items_pro->estatus_id  ==  obtenerIdCatalogoElementCodigo('expediente_recibido')): ?>
            <div class="row  bg-white sub-titulo-red">
                <div class="bg-border mb-3"></div>
                Respuesta
            </div>
            <div class="row bg-white">
                <div class="col-12">
                    <span>Detalle de la respuesta</span>
                    <p><?php echo $denuncia->solicitudExpedienteDGIT('expediente_recibido')->observacion ??'Dato no proporcionado'; ?></p>
                </div>
                <div class="col-12 bg-white">
                    <?php $__empty_2 = true; $__currentLoopData = $docs_respuesta_solicitud_expediente; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                        <?php echo $__env->make('denuncias.fragmentos.documento', ['item' => $item], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                        <p>Dato no proporcionado.</p>
                    <?php endif; ?>

                </div>
            </div>
        <?php endif; ?>
        <?php if( $items_pro->estatus_id  ==  obtenerIdCatalogoElementCodigo('solicitud_expediente')): ?>
            <div class="row bg-white">
                <div class="col-12 text-danger">
                    <h6 class="fw-bolder">Información de la solicitud</h6>
                </div>
                <div class="row">
                    <div class="col">
                        <span class="mb-3">Fecha</span>
                        <p><?php echo e($items_pro->created_at->format('d/m/Y H:i')); ?> </p>
                    </div>
                    <div class="col">
                        <span class="mb-3">Jefe regional de inspección</span>
                        <p><?php echo e($items_pro->asignado->NombreCompleto); ?></p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <span class="mb-3">Información adicional</span>
                        <?php if(isset($items_pro->observacion)): ?>
                            <div class="text-justify f-10 break-w"><?php echo $items_pro->observacion; ?></div>
                        <?php else: ?>
                            <p>Dato no proporcionado.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if(isset($doc_solicitar_expe->ruta)): ?>
                    <?php echo $__env->make('denuncias.fragmentos.documento', ['item' => $doc_solicitar_expe], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

    <?php endif; ?>

<?php /**PATH C:\laragon\www\sglle-honduras\resources\views/denuncias/fragmentos/info-solicitud-expediente.blade.php ENDPATH**/ ?>