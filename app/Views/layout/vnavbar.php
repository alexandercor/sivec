<?php
    $session = session('dataPer');
    
    if(!empty($session)){
        $dni     = $session->dni;
        $persona = $session->persona;
        $email   = $session->email;
    }else{
        header("Location: http://localhost/ci4-sivec-app/public/acceso");
    }
?>

<nav class="main-header navbar navbar-expand navbar-dark navbar-info navbar-light border-bottom-0">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?= base_url(); ?>home" class="nav-link">Inicio</a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
          <img src="resources/img/user.png" class="user-image img-circle elevation-2" alt="User Image">
          <span class="d-none d-md-inline"><?= $persona; ?></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <li class="user-header bg-ligth">
            <img src="resources/img/user.png" class="img-circle elevation-2" alt="User Image">
            <p>
                <?= $persona; ?>
                <small><?= $email; ?></small>
            </p>
          </li>
          <!-- <li class="user-body">
            <div class="row">
              <div class="col-4 text-center">
                <a href="#">Followers</a>
              </div>
              <div class="col-4 text-center">
                <a href="#">Sales</a>
              </div>
              <div class="col-4 text-center">
                <a href="#">Friends</a>
              </div>
            </div>
          </li> -->

          <li class="user-footer">
            <!-- <a href="#" class="btn btn-default btn-flat">Profile</a> -->
            <a href="<?= base_url(); ?>logout" class="btn float-right btn-danger">Cerrar sesion</a>
          </li>
        </ul>
      </li>
    </ul>
  </nav>