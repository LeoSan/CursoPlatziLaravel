
<div class="modal fade modal-denuncia" id="confirmaActualizarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div id="modalHeader" class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Confirmar </h5>
          <button type="button" class="btn-circle" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <span id="msjConfirmacion"> <?php echo e($msj_confirm); ?> </span>
        </div>
        <div class="modal-footer">
          <button data-dismiss="modal" type="button" class="btn btn-secondary">Cancelar</button>
            <?php switch($accion):
                case ('modalSolicitarExpediente'): ?>
                    <a id="<?php echo e($id_boton); ?>" href="<?php echo e(route('denuncias.form.solicitar.expediente', ['id'=>$denuncia->id])); ?>"  type="button" class="btn btn-green a-pta"><?php echo e($nomBoton); ?></a>
                <?php break; ?>
                <?php case ('ClickEnviarActualizacion'): ?>
                    <button id="<?php echo e($id_boton); ?>"  data-modal="SiSoyModal" data-dismiss="modal" type="button" class="btn btn-green"><?php echo e($nomBoton); ?></button>
                <?php break; ?>
            <?php endswitch; ?>
        </div>
      </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\sglle-honduras\resources\views/denuncias/partials/modal-confirm.blade.php ENDPATH**/ ?>