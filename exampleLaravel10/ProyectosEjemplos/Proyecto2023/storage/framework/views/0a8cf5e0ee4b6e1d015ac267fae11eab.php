<?php $__env->startSection('content'); ?>
    <nav aria-label="breadcrumb" class="px-2 py-1">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-small-size"><a href="#">Denuncias</a></li>
            <li class="breadcrumb-item font-small-size active" aria-current="page">Bandeja de denuncias</li>
        </ol>
    </nav>
    <div class="px-2 pb-3 pt-0">
        <h5 class="fw-semibold">
            <div class="">
                Bandeja de denuncias
            </div>
        </h5>
    </div>
    <div class="px-2 pb-4 pt-0">
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('bandeja-denuncias', ['busqueda' => @$_GET['busqueda']])->html();
} elseif ($_instance->childHasBeenRendered('UiSv7lI')) {
    $componentId = $_instance->getRenderedChildComponentId('UiSv7lI');
    $componentTag = $_instance->getRenderedChildComponentTagName('UiSv7lI');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('UiSv7lI');
} else {
    $response = \Livewire\Livewire::mount('bandeja-denuncias', ['busqueda' => @$_GET['busqueda']]);
    $html = $response->html();
    $_instance->logRenderedChild('UiSv7lI', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sglle-honduras\resources\views/denuncias/index.blade.php ENDPATH**/ ?>