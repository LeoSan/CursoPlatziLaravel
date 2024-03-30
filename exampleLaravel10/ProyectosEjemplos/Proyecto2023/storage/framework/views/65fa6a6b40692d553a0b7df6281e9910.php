<div class="header header-app shadow-sm">
    <nav class="navbar navbar-expand-md navbar-dark
     bg-tertiary topbar px-1 px-md-3">
            <a class="navbar-brand d-flex flex-row align-items-center px-0" href="
            <?php echo e(Auth::user()->area->codigo == 'ati' ? route('denuncias.index') : route('casos.index', ['asignado'=>Auth::user()->id, 'estatus'=>precargaEstatus()])); ?>">
            <span class="image">
                <img src="<?php echo e(asset('images/logo-w-2x.png')); ?>" width="140" alt="Logo <?php echo e(config('app.name', 'PRG')); ?>">
            </span>
            <div class="vr text-white mx-0 mx-md-3 d-none d-md-inline"></div>
            <div class="d-none d-md-inline fw-normal">
                <?php echo getNombreSistemaHtml(Auth::user()->id); ?>

            </div>
            <div class="d-inline d-md-none fw-normal f-8 mx-0">
                <?php echo getNombreSistemaHtml(Auth::user()->id); ?>

            </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="<?php echo e(__('Toggle navigation')); ?>">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">
                </ul>
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto py-1 py-md-0">
                    <?php if(auth()->guard()->check()): ?>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle lh-sm text-white" href="#" role="button"
                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <span class="title fw-semibold fs-small">
                                    <?php echo e(Auth::user()->name); ?>

                                </span>
                                <br>
                                <span class="title fw-normal fs-small">
                                    <small><?php echo e(Auth::user()->posicion ?? 'Usuario'); ?></small>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end fs-small" aria-labelledby="navbarDropdown">
                                <?php if(auth()->user()->is_admin): ?>
                                    <a class="dropdown-item" href="<?php echo e(auth()->user()->admin_url); ?>">
                                        Administración
                                    </a>
                                    <a class="dropdown-item" href="<?php echo e(route('home')); ?>">
                                        Inicio
                                    </a>
                                <?php endif; ?>
                                <a class="dropdown-item" href="<?php echo e(route('cuenta.password')); ?>">
                                    Cambiar contraseña
                                </a>
                                <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                                   onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                    <?php echo e(__('Logout')); ?>

                                </a>
                                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                                    <?php echo csrf_field(); ?>
                                </form>
                            </div>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
    </nav>
    <div class="bg-tertiaryAlt">
        <div class="container d-flex gap-4">
            <?php if(url_activa('admin*') || url_activa('auditorias*') || url_activa('denuncias*')): ?>
                <button id="btnNavbar" class="btn d-md-none px-0">
                    <i class="fa fa-bars"></i> <span class="text-decoration-none">Menú</span>
                </button>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\sglle-honduras\resources\views/partials/header-app.blade.php ENDPATH**/ ?>