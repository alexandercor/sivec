<?= $this->extend('layout/vlayout') ?>
<!--  -->
<?= $this->section('page_title') ?> Reportes - Consolidado Diario | <?= SYS_TITLE; ?> 
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><i class="fas fa-sliders-h"></i> Reportes - Consolidado Diario</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('home')?>">Inicio</a></li>
              <li class="breadcrumb-item active">Reportes - Consolidado Diario</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
        <div class="container-fluid" id="div_overlay">
            <div class="row">
                <div class="col-12">
                    <div class="card card-navy card-outline">
                        <div class="card-header p-0">
                            <ul id="tab_loc" class="nav nav-pills ml-auto p-2">
                                <li class="nav-item"><a class="nav-link active" href="#tabloc" data-toggle="tab"><i class="fas fa-file-excel"></i> Reporte</a></li>
                                <!-- <li class="nav-item"><a class="nav-link" href="#tabadd" data-toggle="tab">Agregar</a></li> -->
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tabloc">
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="sle_secview_locali">Fecha Inicia</label>
                                                <input type="date" class="form-control form-control-lg" id="dte_con_view_fechaini">
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="sle_secview_locali">Fecha Fin</label>
                                                <input type="date" class="form-control form-control-lg" id="dte_con_view_fechafin">
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <a href="<? base_url('')?>" id="btn_inspecciones_buscar" class="btn btn-success btn-lg mt-4"> <i class="fas fa-file-excel"></i> Consolidado Diario</a>
                                            </div>                    
                                        </div>
                                    </div>
                                    <hr class="mt-0">
                                    
                                </div>
                                <div class="tab-pane" id="tabadd">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?= $this->endSection() ?>

<?= $this->section('javascript') ?>


<?= $this->endSection() ?>