<?= $this->extend('layout/vlayout') ?>
<!--  -->
<?= $this->section('page_title') ?> Reportes - Inspección | <?= SYS_TITLE; ?> 
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><i class="fas fa-sliders-h"></i> Reportes - Inspección para la Vigilancio y Control</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('home')?>">Inicio</a></li>
              <li class="breadcrumb-item active">Reportes - Inspección</li>
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
                                <li class="nav-item"><a class="nav-link active" href="#tabloc" data-toggle="tab">Lista</a></li>
                                <li class="nav-item"><a class="nav-link" href="#tabadd" data-toggle="tab">Agregar</a></li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tabloc">
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="sle_locview_region">Region</label>
                                                <select id="sle_locview_region" class="form-control" data-send="view">
                                                    <option value="">Selecciona una región</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="sle_locview_depa">Departamento</label>
                                                <select id="sle_locview_depa" class="form-control" data-send="view">
                                                    <option value="">Selecciona un departamento</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="sle_locview_prov">Provincia</label>
                                                <select id="sle_locview_prov" class="form-control" data-send="view">
                                                    <option value="">Selecciona una provincia</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="sle_locview_distr">Distrito</label>
                                                <select id="sle_locview_distr" class="form-control" data-send="view">
                                                    <option value="">Selecciona una distrito</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="txt_locview_loc" >Localidad</label>
                                                <input type="text" class="form-control text-uppercase" id="txt_locview_loc"   placeholder="Localidad">
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12">  
                                            <div class="form-group">
                                                <label for="" class="color_white">.</label>
                                                <a href="<?= base_url();?>reportes/inspeccion" id="btn_excel" class="btn btn-primary btn-block">Buscar</a>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="mt-0">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
                                            <table id="tbl_loc" class="table table-striped table-bordered table-sm table-hover projects">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Localidad</th>
                                                        <th>Distrito</th>
                                                        <th>Provincia</th>
                                                        <th>Departamento</th>
                                                        <th>Region</th>
                                                        <th>Acc.</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tabadd">
                                    <div class="card card-primary">
                                        <form id="frm_loc" action="<?= base_url(); ?>localidad/add" method="POST">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div id="div_errors" class="error_danger"></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <input type="hidden" name="txt_loccrud_esta" id="txt_loccrud_esta" value="MQ--">

                                                    <input type="hidden" name="txt_loccrud_keyloca" id="txt_loccrud_keyloca">

                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label for="sle_loccrud_region">Region</label>
                                                            <select id="sle_loccrud_region" class="form-control" data-send="crud">
                                                                <option value="">Selecciona una región</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label for="sle_loccrud_depa">Departamento</label>
                                                            <select id="sle_loccrud_depa" class="form-control" data-send="crud">
                                                                <option value="">Selecciona un departamento</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label for="sle_loccrud_prov">Provincia</label>
                                                            <select id="sle_loccrud_prov" class="form-control" data-send="crud">
                                                                <option value="">Selecciona una provincia</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label for="sle_loccrud_distr">Distrito</label>
                                                            <select id="sle_loccrud_distr" name="sle_loccrud_distr" class="form-control" data-send="crud">
                                                                <option value="">Selecciona una distrito</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label for="txt_loccrud_loc" >Localidad</label>
                                                            <input type="text" class="form-control text-uppercase" id="txt_loccrud_loc" name="txt_loccrud_loc"   placeholder="Localidad">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <div class="row justify-content-between">
                                                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                                        <div id="div_response"></div>
                                                        
                                                    </div>
                                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                                        <button type="submit" class="btn btn-primary btn-block">Guardar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?= $this->endSection() ?>