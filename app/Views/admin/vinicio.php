<?= $this->extend('layout/vlayout') ?>
<!--  -->
<?= $this->section('page_title') ?> Bienvenido <?= $this->endSection() ?>

<?= $this->section('contenido') ?>

  <!-- Content Header (Page header) -->
  <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Inicio</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('/home'); ?>">Inicio</a></li>
                    <li class="breadcrumb-item active"></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="container-fluid">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-center">
                            <img src="<?= base_url();?>resources/img/logo_login.png" width="270">
                        </div>
                    </div>

                    <div class="row d-flex justify-content-center">
                        <div class="col-12">
                            <h4 class="login-box-msg font-weight-bold m-0">CEM</h4>
                            <p class="login-box-msg">Control de Enfermedades Metaxénicas</p>
                        </div>
                    </div>

                    <hr>

                    <div class="row d-flex justify-content-center">
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-primary">
                            <div class="inner">
                                <h3>Usuarios</h3>
                                <p></p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="<?= base_url('usuarios'); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-teal">
                            <div class="inner">
                                <h3>Inspectores</h3>
                                <p></p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="<?= base_url('seguimiento'); ?>" class="small-box-footer">Ir <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>Sospechosos</h3>
                                <p></p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="<?= base_url('seguimiento-sospechosos'); ?>" class="small-box-footer">Ir <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


<?= $this->endSection() ?>

<?= $this->section('javascript') ?>

  <script type='text/javascript' >
    // alert('hola')
  </script>

<?= $this->endSection() ?>