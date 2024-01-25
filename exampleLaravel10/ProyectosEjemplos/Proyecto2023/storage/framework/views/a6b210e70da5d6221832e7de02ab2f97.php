<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name', 'SETRASS')); ?></title>
    <?php echo app('Illuminate\Foundation\Vite')('resources/sass/app.scss'); ?>
</head>
<body>
<?php echo $__env->make('partials.header-app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div id="app" class="mb-5">
    <?php if(url_activa('admin*')): ?>
        <?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
    <?php if(url_activa('denuncias*') || url_activa('planeaciones*') || url_activa('auditorias*')): ?>
        <?php echo $__env->make('layouts.sidebar-ati', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
    <main id="content-app" class="d-flex flex-column">
        <div id="content">
            <div class="container pt-3">
                <?php echo $__env->make('layouts.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </div>
    </main>
</div>
<?php echo $__env->make('partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo \Livewire\Livewire::scripts(); ?>

</body>
<script type="module">
    window.base_url = "<?php echo e(url('/')); ?>";
    window.post_size = "<?php echo e(ini_get('post_max_size')); ?>";
</script>
<?php echo app('Illuminate\Foundation\Vite')('resources/js/app.js'); ?>
</html>
<?php /**PATH C:\laragon\www\sglle-honduras\resources\views/layouts/app.blade.php ENDPATH**/ ?>