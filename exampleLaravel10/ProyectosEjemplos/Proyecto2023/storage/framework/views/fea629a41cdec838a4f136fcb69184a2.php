<nav aria-label="breadcrumb" class="px-2 py-1">
    <ol class="breadcrumb">
        <?php $__currentLoopData = $itemsbread; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="breadcrumb-item <?php echo e($item['value']); ?> font-small-size">
                <?php if($item['value'] != 'active'): ?>
                    <a href="<?php echo e($item['ruta']); ?>"> <?php echo e($item['nombreComponente']); ?> </a>
                <?php else: ?>
                    <?php echo e($item['nombreComponente']); ?>

                <?php endif; ?>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ol>
 </nav>
<?php /**PATH C:\laragon\www\sglle-honduras\resources\views/components/bread-crumbs.blade.php ENDPATH**/ ?>