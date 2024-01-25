
    <div class="form-group col-md-3 mb-2 mb-md-0 d-flex  justify-content-end">
        <a  class="btn btn-accion-detalle  
            <?php echo e(($denuncia->estatus->codigo == 'informe_actualizado' || $denuncia->estatus->codigo == 'informe_cargado')? 'bg-estatus-inadmision':'bg-btn-reasignar-auditor'); ?>   
            w-100"
        href="<?php echo e(route('denuncias.form.reasignar.auditor',$denuncia->id)); ?>">
        Reasignar auditor
        </a>
    </div>
<?php /**PATH C:\laragon\www\sglle-honduras\resources\views/denuncias/botones/acciones-st-reasignar-auditor.blade.php ENDPATH**/ ?>