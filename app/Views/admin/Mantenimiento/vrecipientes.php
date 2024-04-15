<?= $this->extend('layout/vlayout') ?>
<!--  -->
<?= $this->section('page_title') ?> Recipientes | <?= SYS_TITLE; ?> <?= $this->endSection() ?>

<?= $this->section('contenido') ?>

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><i class="fas fa-sliders-h"></i> Recipientes</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('home')?>">Inicio</a></li>
              <li class="breadcrumb-item active">Recipientes</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-navy">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-user-circle"></i> Datos</h3>
                        </div>
                        <form>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Denominación</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Denominación">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
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