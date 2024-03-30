<p class="m-0 text-end fw-bold">
    <a class="text-graydark d-inline d-md-none text-sin-subrayado fs-movil" data-bs-toggle="collapse" href="#collapseFiltrosDenuncias" role="button" aria-expanded="true" aria-controls="collapseFiltrosDenuncias">
        Filtros<span class="image"><img src="<?php echo e(asset('images/icons/icon-arrow-down-fill.svg')); ?>" class="ms-1"></span>
    </a>
</p>
<div class="collapse show" id="collapseFiltrosDenuncias">
    <div class="" id="contenedorCollapseFiltrosDenuncias">
        <div class="row justify-content-start">
            <div class="col-md-4 col-sm-12 py-1">
                <label class="col-auto label-xs small text-gray pt-1 mb-0">Fecha de la denuncia:</label>
                <div class="row m-0 p-0">
                    <div class="col-6 p-0 pe-1">
                        <input type="<?php echo e($fecha_denuncia_desde||$fecha_denuncia_hasta?'date':'text'); ?>" class="form-control filtro-text w-100 input-filter-height filtro-fecha" placeholder="Desde"
                               wire:model="fecha_denuncia_desde">
                    </div>
                    <div class="col-6 p-0 ps-1">
                        <input type="<?php echo e($fecha_denuncia_desde||$fecha_denuncia_hasta?'date':'text'); ?>" class="form-control filtro-text w-100 input-filter-height filtro-fecha" placeholder="Hasta"
                               wire:model="fecha_denuncia_hasta">
                    </div>
                </div>
                <?php if(isset($filtros['fecha_denuncia']['error'])): ?>
                    <div class="row p-0 m-0 text-center">
                        <small class="text-danger" style="font-size: 10px"><?php echo e($filtros['fecha_denuncia']['error']); ?></small>
                    </div>
                <?php endif; ?>
            </div>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ver_completa_bandeja_denuncias')): ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->denies('ver_limitada_bandeja_denuncias')): ?>
                    <div class="col-md-4 col-sm-12 py-1">
                        <label for="departamento_filtro" class="col-auto label-xs small text-gray pt-1 mb-0">Departamento:</label>
                        <select wire:model="departamento" class="form-select filtro-select input-filter-height" id="departamento_filtro">
                            <option value="">Todos</option>
                            <?php $__currentLoopData = $cat_departa; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($i->id); ?>"><?php echo e($i->nombre); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-12 py-1">
                        <label for="origen_filtro" class="col-auto label-xs small text-gray pt-1 mb-0">Origen:</label>
                        <select wire:model="origen" class="form-select filtro-select input-filter-height" id="origen_filtro">
                            <option value="">Todos</option>
                            <?php $__currentLoopData = $cat_origen; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($i->id); ?>"><?php echo e($i->nombre); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-12 py-1">
                        <label for="recepcion" class="col-auto  label-xs small text-gray pt-1 mb-0">Medio de recepción:</label>
                        <select wire:model="recepcion" class="form-select filtro-select input-filter-height" id="recepcion">
                            <option value="">Todos</option>
                            <?php $__currentLoopData = $cat_medio_recepcion; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($i->id); ?>"><?php echo e($i->nombre); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ver_toda_bandeja_denuncias')): ?>
                        <div class="col-md-4 col-sm-12 py-1">
                            <label for="auditor_asignado" class="col-auto label-xs small text-gray pt-1 mb-0">Asignado a:</label>
                            <select wire:model="asignado" class="form-select filtro-select input-filter-height" id="auditor_asignado">
                                <option value="">Todos</option>
                                <?php $__currentLoopData = $cat_auditors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($i->id); ?>"><?php echo e($i->complete_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>

            <div class="col-md-4 col-sm-12 py-1">
                <label for="estatus_filtro" class="col-auto  label-xs small text-gray pt-1 mb-0">Estatus:</label>
                <select wire:model="estatus" class="form-select filtro-select input-filter-height" id="estatus_filtro">
                    <option value="">Todos</option>
                    <?php $__currentLoopData = $cat_estatus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($i->id); ?>"><?php echo e($i->nombre); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <?php if($filtrado): ?>
                <div class="col-md-12 mt-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="w-100">
                            <div class="row">
                                <?php $__currentLoopData = $filtros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(isset($i['valor'])): ?>
                                        <div class="col-md-auto col-sm-12">
                                            <div class="badge rounded-pill text-bg-light px-2 py-0 w-100 badge-filtro">
                                                <small><strong><?php echo e($i['texto']); ?></strong></small>
                                                <small><?php echo e($i['valor']); ?></small>
                                                <button class="btn p-0 px-1 m-0" wire:click="removeFiltro('<?php echo e($k); ?>')">
                                                    <i class="fa fa-times text-danger"></i>
                                                </button>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                        <div class="">
                            <button class="btn btn-default input-regular-height text-nowrap" wire:click="resetFiltros">Limpiar filtros</button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="col-12 mt-3">
                <div class="border-bottom"></div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\sglle-honduras\resources\views/livewire/partials/filtros_denuncia.blade.php ENDPATH**/ ?>