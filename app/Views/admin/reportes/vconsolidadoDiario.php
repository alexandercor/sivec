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
                                                <label for="dte_con_view_fechaini">Fecha Inicia</label>
                                                <input type="date" class="form-control form-control-lg" id="dte_con_view_fechaini">
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="dte_con_view_fechafin">Fecha Fin</label>
                                                <input type="date" class="form-control form-control-lg" id="dte_con_view_fechafin">
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <botton type="botton" id="btn_consolidado_buscar" class="btn btn-primary btn-lg btn-block mt-4"> <i class="fas fa-search" aria-hidden="true"></i> Buscar</botton>
                                            </div>                    
                                        </div>

                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <a href="#" id='lnk_consolidado_generar' class="btn btn-success btn-lg mt-4 hidden"> <i class="fas fa-file-excel"></i> Consolidado Diario</a>
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

    <script type="text/javascript">
        $(() => {
            $dte_con_view_fechaini = $('#dte_con_view_fechaini');
            $dte_con_view_fechafin = $('#dte_con_view_fechafin');
            $btn_consolidado_buscar = $('#btn_consolidado_buscar');
            $lnk_consolidado_generar = $('#lnk_consolidado_generar');
            
        })

        $dte_con_view_fechaini = $('#dte_con_view_fechaini');
        $dte_con_view_fechafin = $('#dte_con_view_fechafin');
        $btn_consolidado_buscar = $('#btn_consolidado_buscar');
        $lnk_consolidado_generar = $('#lnk_consolidado_generar');

        $btn_consolidado_buscar.click(function (e) { 
            e.preventDefault();
            // $dte_con_view_fechaini.val('');
            // $dte_con_view_fechafin.val('');

            const fini = $dte_con_view_fechaini.val();
            const ffin = $dte_con_view_fechafin.val();

            if(fini && ffin){
                $lnk_consolidado_generar.css({'visibility': 'visible'});
                const newUrl = `${base_url}reportes/consolidado-diario/xls/${fini}/${ffin}`;
                $lnk_consolidado_generar.prop('href', newUrl);

            }else{
                alert('no hay')
            }

        });

    </script>

<?= $this->endSection() ?>