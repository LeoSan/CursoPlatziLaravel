
<?php $__empty_1 = true; $__currentLoopData = $denuncia->gestion_denuncia; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $items_pro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <?php if($items_pro->estatus_id == obtenerIdCatalogoElementCodigo('en_revision')): ?>
    <div class="row bg-white">
        <div class="row">
            <div class="col">
                <span>¿Se notificó a la DGIT?</span>
                <?php if(  strlen($denuncia->correo_dgit) > 0   == 1): ?>
                    <p> Sí | <?php echo e(strtolower($denuncia->correo_dgit)); ?></p>
                <?php else: ?>
                    <p> No</p>
                <?php endif; ?>
            </div>
            <div class="col">
                <span>Número de expediente DGIT</span>
                <p><?php echo e($denuncia->num_expediente_dgit); ?></p>
            </div>
            <div class="col">
                <span>Número de expediente ATI</span>
                <p><?php echo e($denuncia->num_expediente); ?></p>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <span>Observaciones</span>
                <?php if(isset($items_pro->observacion)): ?>
                    <div class="text-justify f-10 break-w"><?php echo $items_pro->observacion; ?></div>
                <?php else: ?>
                    <p>Dato no proporcionado.</p>
                <?php endif; ?>

            </div>
        </div>
        <?php if(isset($doc_alta_denun->ruta)): ?>
        <div class="col-12 mb-3">
            <?php echo $__env->make('denuncias.fragmentos.documento', ['item' => $doc_alta_denun], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <?php endif; ?>
    </div>


    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

<?php endif; ?>
<?php /**PATH C:\laragon\www\sglle-honduras\resources\views/denuncias/fragmentos/info-alta-denuncia.blade.php ENDPATH**/ ?>