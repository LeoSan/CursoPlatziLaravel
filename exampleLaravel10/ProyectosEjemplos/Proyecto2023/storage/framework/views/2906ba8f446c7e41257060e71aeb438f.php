<div class="<?php if(isset($col)): ?><?php echo e($col); ?> <?php else: ?> <?php echo e($col); ?> <?php endif; ?>   bg-white sub-titulo-red">
<div class="bg-border mb-3"></div>
    Pruebas
</div>
<div class=" ">
    <div class="row bg-white">
        <?php $__empty_1 = true; $__currentLoopData = $doc_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php echo $__env->make('denuncias.fragmentos.documento', ['item' => $item], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p>Dato no proporcionado.</p>
        <?php endif; ?>
    </div>

</div>

<?php /**PATH C:\laragon\www\sglle-honduras\resources\views/denuncias/fragmentos/info-pruebas-denuncia.blade.php ENDPATH**/ ?>