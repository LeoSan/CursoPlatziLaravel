<?php
    use App\Http\Livewire\BandejaDenuncias;
?>
<span class="badge rounded-circle bg-estatus-<?php echo e($denuncia->estatus->codigo); ?>">&nbsp;</span>
<strong class="text-estatus-<?php echo e($denuncia->estatus->codigo); ?>"><?php echo e($denuncia->estatus->nombre); ?></strong>

<?php switch( $denuncia->estatus->codigo):
    case ('solicitud_expediente'): ?>
        </br>
        <spam class="f-10">
            <?php echo e(BandejaDenuncias::calculoDiasPlazo($denuncia)); ?>

        </spam>
    <?php break; ?>
    <?php case ('providencia'): ?>
        </br>
        <spam class="f-10">
            <?php echo e(BandejaDenuncias::calculoDiasPlazo($denuncia)); ?>

        </spam>
    <?php break; ?>
    <?php default: ?>
        
        <?php if( $denuncia->hasEstatus('admitida') && !$denuncia->hasEstatus('finalizado')  ): ?>
        </br>
        <spam class="f-10">
            <?php echo e(BandejaDenuncias::calculoDiasPlazo($denuncia)); ?>

        </spam>
        <?php endif; ?>
<?php endswitch; ?>



<?php /**PATH C:\laragon\www\sglle-honduras\resources\views/denuncias/fragmentos/status.blade.php ENDPATH**/ ?>