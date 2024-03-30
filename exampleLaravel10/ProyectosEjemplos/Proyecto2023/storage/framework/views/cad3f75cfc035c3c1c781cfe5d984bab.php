<?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'denunciante')): ?>
    <a href="<?php echo e(route('denuncias.informacion.adicional', $denuncia->id )); ?>" class="text-dark">
        <strong><?php echo e($denuncia->folio??"Sin expediente asignado"); ?></strong>
    </a>
<?php else: ?>
    
    <?php if($estatus_providencia == $denuncia->estatus->id): ?>
        <a href="<?php echo e(route('denuncias.informacion.adicional', $denuncia->id )); ?>" class="text-dark">
            <strong><?php echo e($denuncia->folio??"Sin expediente asignado"); ?></strong>
        </a>
    <?php else: ?>
        <a href="<?php echo e(route('denuncias.detalle', $denuncia->id )); ?>" class="text-dark">
            <strong><?php echo e($denuncia->folio??"Sin expediente asignado"); ?></strong>
        </a>
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\sglle-honduras\resources\views/denuncias/fragmentos/folio.blade.php ENDPATH**/ ?>