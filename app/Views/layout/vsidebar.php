<?php
    $session = session('dataPer');

    if(!empty($session) && !empty($session->key_nive)){
        $keyNivel = (int) $session->key_nive;
    } else {
        header('Location: ' . base_url('acceso'));
        exit;
    }
?>

<aside class="main-sidebar sidebar-dark-olive elevation-4">
    <div class="brand-link">
      <img src="<?= base_url();?>resources/img/logo_login.png" width="50" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light"> CEM</span>
    </div>
    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="<?= base_url('home'); ?>" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                    Inicio
                </p>
                </a>
            </li> 
            <?php if($keyNivel === 1): ?>
                <li class="nav-item">
                    <a href="<?= base_url('usuarios'); ?>" class="nav-link">
                    <i class="fas fa-users"></i>
                    <p>
                        Usuarios
                    </p>
                    </a>
                </li>
                <li class="nav-item menu-is-opening">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            Mantenimiento
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('/persona');?>" class="nav-link">
                            <i class="fas fa-list nav-icon"></i>
                            <p>Colaborador</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('/recipientes');?>" class="nav-link">
                            <i class="fas fa-list nav-icon"></i>
                            <p>Recipientes</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('/actividades');?>" class="nav-link">
                            <i class="fas fa-list nav-icon"></i>
                            <p>Actividades</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('/essalud');?>" class="nav-link">
                            <i class="fas fa-list nav-icon"></i>
                            <p>Establecimiento de salud</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('/localidad');?>" class="nav-link">
                            <i class="fas fa-list nav-icon"></i>
                            <p>Localidad</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('/sector');?>" class="nav-link">
                            <i class="fas fa-list nav-icon"></i>
                            <p>Sector</p>
                            </a>
                        </li>
                    </ul>
                </li>
            <?php endif ?>

            <?php if($keyNivel === 1 || $keyNivel === 3): ?>    
                <li class="nav-item">
                    <a href="<?= base_url('/seguimiento'); ?>" class="nav-link">
                    <i class="fas fa-cubes"></i>
                    <p>
                        Seguimiento inspectores
                    </p>
                    </a>
                </li>
            <?php endif ?>

            <?php if($keyNivel === 1 || $keyNivel === 3): ?>    
                <li class="nav-item">
                    <a href="<?= base_url('/seguimiento-sospechosos'); ?>" class="nav-link">
                    <i class="fas fa-route"></i>
                    <p>
                        Seguimiento sospechosos
                    </p>
                    </a>
                </li>
            <?php endif ?>

            <?php if($keyNivel === 1 || $keyNivel === 3): ?>
                <li class="nav-item menu-is-opening menu-open">
                    <a href="#" class="nav-link">
                        <i class="fas fa-signal"></i>
                        <p>
                            Reportes
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('reportes-inspeccion');?> " class="nav-link">
                            <i class="fas fa-list nav-icon"></i>
                            <p>Inspección y Control</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('reportes-consolidado-diario');?> " class="nav-link">
                            <i class="fas fa-list nav-icon"></i>
                            <p>Consolidado Diario</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('reportes-sector');?> " class="nav-link">
                            <i class="fas fa-list nav-icon"></i>
                            <p>Por sector</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('reportes-indices');?> " class="nav-link">
                            <i class="fas fa-list nav-icon"></i>
                            <p>Por Indices</p>
                            </a>
                        </li>
                    </ul>
                    <!-- <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('reportes-inspector');?> " class="nav-link">
                            <i class="fas fa-list nav-icon"></i>
                            <p>Por Inspector</p>
                            </a>
                        </li>
                    </ul> -->
                </li>

                <li class="nav-item menu-is-opening menu-open">
                    <a href="#" class="nav-link">
                        <i class="fas fa-signal"></i>
                        <p>
                            Graficos
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('graficos-sector');?> " class="nav-link">
                            <i class="fas fa-list nav-icon"></i>
                            <p>Por sector</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('graficos-localidad');?> " class="nav-link">
                            <i class="fas fa-list nav-icon"></i>
                            <p>Por Localidad</p>
                            </a>
                        </li>
                    </ul>
                </li>
            <?php endif ?>

            <!-- <li class="nav-item">
                <a href="<?= base_url('control'); ?>" class="nav-link">
                <i class="fas fa-cubes"></i>
                <p>
                    Control
                </p>
                </a>
            </li> -->
        </ul>
      </nav>
    </div>
</aside>