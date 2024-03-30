<div class="row  bg-white sub-titulo-red">
    Datos del denunciante
</div>

<div class="row bg-white">
    <div class="col-sm-4 col-xs-12 ">
        <span>Origen de la denuncia</span>
        <p><?php echo e($denuncia->origen->nombre); ?></p>
    </div>
</div>
<div class="row bg-white">
    <?php if($denuncia->sindicato_denunciante == 'N/A'): ?>
        <div class="col-sm-4 col-xs-12">
            <span>Nombre</span>
            <p class="text-break"><?php echo e($denuncia->nombre_denunciante); ?></p>
        </div>
        <div class="col-sm-4 col-xs-12">
            <span>Primer apellido</span>
            <p class="text-break"><?php echo e($denuncia->primer_apellido_denunciante); ?></p>
        </div>
        <div class="col-sm-4 col-xs-12">
            <span>Segundo apellido</span>
            <p class="text-break"><?php echo e($denuncia->segundo_apellido_denunciante); ?></p>
        </div>
    <?php else: ?>
        <div class="col-sm-4 col-xs-12">
            <span>Nombre del sindicato</span>
            <p><?php echo e($denuncia->sindicato_denunciante); ?></p>
        </div>
    <?php endif; ?>
</div>
<div class="row bg-white">
    <div class="col-sm-4 col-xs-12">
        <span>Documento de Identificación Nacional</span>
        <p><?php echo e($denuncia->dni_denunciante); ?></p>
    </div>
    <div class="col-sm-4 col-xs-12">
        <span>Tel&eacute;fono</span>
        <p><?php echo e($denuncia->telefono_denunciante); ?></p>
    </div>
    <div class="col-sm-4 col-xs-12">
        <span>Correo electrónico</span>
        <p><?php echo e($denuncia->correo_denunciante); ?></p>
    </div>
</div>


<?php if(empty($denuncia->domicilio)): ?>
    <div class="row bg-white sub-titulo-gray ">
        Domicilio del Denunciante
    </div>
    <div class="row bg-white">
        <p class="mt-3 text-break">Dato no proporcionado.</p>
    </div>
<?php else: ?>
    <div class="row bg-white sub-titulo-gray ">
        Domicilio del Denunciante
    </div>
    <div class="row bg-white py-2">
        <div class="col-sm-4 col-xs-12">
            <span>Calle</span>
            <?php if(empty($denuncia->domicilio->calle)): ?>
                <p>Dato no proporcionado</p>
            <?php else: ?>
                <p class="text-break"><?php echo e($denuncia->domicilio->calle); ?></p>
            <?php endif; ?>
        </div>
        <div class="col-sm-4 col-xs-12">
            <span>Número exterior</span>
            <?php if(empty($denuncia->domicilio->num_exterior)): ?>
                <p>Dato no proporcionado</p>
            <?php else: ?>
                <p class="text-break"><?php echo e($denuncia->domicilio->num_exterior); ?></p>
            <?php endif; ?>
            
        </div>
        <div class="col-sm-4 col-xs-12">
            <span>Número interior</span>
            <?php if(empty($denuncia->domicilio->num_interior)): ?>
                <p>Dato no proporcionado</p>
            <?php else: ?>
                <p class="text-break"><?php echo e($denuncia->domicilio->num_interior); ?></p>
            <?php endif; ?>
            
        </div>
    </div>
    <div class="row bg-white">
        <div class="col-sm-4 col-xs-12">
            <span>Departamento</span>
            <?php if(empty($denuncia->domicilio->departamento->nombre)): ?>
                <p>Dato no proporcionado</p>
            <?php else: ?>
                <p><?php echo e($denuncia->domicilio->departamento->nombre); ?></p>
            <?php endif; ?>
        </div>
        <div class="col-sm-4 col-xs-12">
        <span>Municipio</span>
        <?php if(empty($denuncia->domicilio->municipio->nombre)): ?>
            <p>Dato no proporcionado</p>
        <?php else: ?>
            <p><?php echo e($denuncia->domicilio->municipio->nombre); ?></p>
        <?php endif; ?>
        </div>
        <div class="col-sm-4 col-xs-12">
        <span>Ciudad</span>
        <?php if(empty($denuncia->domicilio->ciudad)): ?>
            <p>Dato no proporcionado</p>
        <?php else: ?>
            <p class="text-break"><?php echo e($denuncia->domicilio->ciudad); ?></p>
        <?php endif; ?>
        </div>
        <div class="col-sm-4 col-xs-12">
        <span>C&oacute;digo postal</span>
        <?php if(empty($denuncia->domicilio->codigo_postal)): ?>
            <p>Dato no proporcionado</p>
        <?php else: ?>
            <p><?php echo e($denuncia->domicilio->codigo_postal); ?></p>
        <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

<div class="row bg-white sub-titulo-red">
    <div class="bg-border mb-3"></div>
    Datos de la denuncia
</div>
<div class="row bg-white">
    <div class="col-sm-4 col-xs-12">
        <span>Fecha</span>
        <p><?php echo e($denuncia->created_at->format('d/m/Y H:i')); ?></p>
    </div>
    <div class="col-sm-4 col-xs-12">
        <span>Medio de recepción</span>

        <?php if(isset($denuncia->medio_recepcion->nombre)): ?>
            <p><?php echo e($denuncia->medio_recepcion->nombre); ?></p>
        <?php else: ?>
            <p>Dato no proporcionado.</p>
        <?php endif; ?>
    </div>
</div>
<div class="row bg-white">
    <div class="col-sm-4 col-xs-12">
        <span>Nombre funcionario</span>
        <p class="text-break"><?php echo e($denuncia->nombre_funcionario); ?></p>
    </div>
    <div class="col-sm-4 col-xs-12">
        <span>Departamento / Municipio</span>
        <p><?php echo e($denuncia->departamento_region->nombre); ?> / <?php echo e($denuncia->municipio_region->nombre); ?></p>
    </div>
    <div class="col-sm-4 col-xs-12">
        <span>Oficina regional</span>
        <p><?php echo e($denuncia->oficina->nombre); ?></p>
    </div>
</div>


<div class="row bg-white">
    <div class="col-12">
        <span>Descripción de la denuncia</span>
        <div class="text-justify f-10 break-w"><?php echo $denuncia->descripcion_denuncia; ?></div>
    </div>

    <?php if(isset($documento->ruta)): ?>
        <?php echo $__env->make('denuncias.fragmentos.documento', ['item' => $documento], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
</div>
<?php /**PATH C:\laragon\www\sglle-honduras\resources\views/denuncias/fragmentos/info-datos-denuncia.blade.php ENDPATH**/ ?>