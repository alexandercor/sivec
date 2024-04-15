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
                            <img src="resources/img/growth_analytics.svg" alt="" width="500">
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