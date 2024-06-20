<?= $this->extend('layout/vlayout') ?>
<!--  -->
<?= $this->section('page_title') ?> Reportes - Indices | <?= SYS_TITLE; ?> 
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><i class="fas fa-sliders-h"></i> Reportes - Indices</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('home')?>">Inicio</a></li>
              <li class="breadcrumb-item active">Reportes - Indices</li>
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
                            <!-- <ul id="tab_loc" class="nav nav-pills ml-auto p-2">
                                <li class="nav-item"><a class="nav-link active" href="#tabloc" data-toggle="tab"><i class="fas fa-file-excel"></i> Reporte</a></li>
                            </ul> -->
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tabloc">
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="sle_repindview_region">Region</label>
                                                <select id="sle_repindview_region" class="form-control" data-send="view">
                                                    <option value="">Selecciona una región</option>
                                                    <?php
                                                        foreach($dataRegiones as $reg){
                                                            $keyReg = bs64url_enc($reg->key_reg);
                                                            echo "<option value='$keyReg'>$reg->reg</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="sle_repindview_depa">Departamento</label>
                                                <select id="sle_repindview_depa" class="form-control" data-send="view">
                                                    <option value="">Selecciona un departamento</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="sle_repindview_prov">Provincia</label>
                                                <select id="sle_repindview_prov" class="form-control" data-send="view">
                                                    <option value="">Selecciona una provincia</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="sle_repindview_distr">Distrito</label>
                                                <select id="sle_repindview_distr" class="form-control" data-send="view">
                                                    <option value="">Selecciona una distrito</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row d-flex align-items-end">
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="sle_repindview_locali">Localidad</label>
                                                <select id="sle_repindview_locali" class="form-control" data-send="view">
                                                    <option value="">Selecciona una localidad</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="dte_ind_view_fechaini">Fecha Inicia</label>
                                                <input type="date" class="form-control form-control-lg" id="dte_ind_view_fechaini">
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="dte_ind_view_fechafin">Fecha Fin</label>
                                                <input type="date" class="form-control form-control-lg" id="dte_ind_view_fechafin">
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <botton type="botton" id="btn_ind_buscar" class="btn btn-primary btn-lg btn-block mt-4"> <i class="fas fa-undo-alt"></i> Generar Reporte</botton>
                                            </div>                    
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <a href="#" id='lnk_ind_generar' class="btn btn-success btn-lg mt-4 hidden"> <i class="fas fa-file-excel"></i> Descargar Reporte</a>
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
            $dte_ind_view_fechaini = $('#dte_ind_view_fechaini');
            $dte_ind_view_fechafin = $('#dte_ind_view_fechafin');
            $btn_ind_buscar = $('#btn_ind_buscar');
            $lnk_ind_generar = $('#lnk_ind_generar');
            
        })

        $sle_repindview_region = $('#sle_repindview_region');
        $sle_repindview_depa = $('#sle_repindview_depa');
        $sle_repindview_prov = $('#sle_repindview_prov');
        $sle_repindview_distr = $('#sle_repindview_distr');
        $sle_repindview_locali = $('#sle_repindview_locali');

        $dte_ind_view_fechaini = $('#dte_ind_view_fechaini');
        $dte_ind_view_fechafin = $('#dte_ind_view_fechafin');
        $btn_ind_buscar = $('#btn_ind_buscar');
        $lnk_ind_generar = $('#lnk_ind_generar');


        $sle_repindview_region.change(function (e) {
            e.preventDefault();
            
            codReg = $(this).val();
            if(codReg){
                $.ajax({
                    url: `${base_url}departamentos`,
                    type: "POST",
                    data: {codReg: codReg},
                    dataType: "JSON",
                })
                .done((data) => {
                    const { status, dataDepartamentos } = data;
                    if(status){
                        $sle_repindview_depa.html(`${dataDepartamentos}`);
                    }
                })
                .fail((jqXHR, statusText) => {
                    fn_errorJqXHR(jqXHR, statusText);
                });
            }
        });

        $sle_repindview_depa.change(function (e) {
            e.preventDefault();
            codDep = $(this).val();

            if(codDep){
                $.ajax({
                    url: `${base_url}provincias`,
                    type: "POST",
                    data: {codDep: codDep},
                    dataType: "JSON",
                })
                .done((data) => {
                    const { status, dataProvincias } = data;
                    if(status){
                        $sle_repindview_prov.html(`${dataProvincias}`);
                    }
                })
                .fail((jqXHR, statusText) => {
                    fn_errorJqXHR(jqXHR, statusText);
                });
            }
        });

        $sle_repindview_prov.change(function (e) {
            e.preventDefault();
            
            codProv = $(this).val();

            if(codDep){
                $.ajax({
                    url: `${base_url}distritos`,
                    type: "POST",
                    data: {codProv: codProv},
                    dataType: "JSON",
                })
                .done((data) => {
                    const { status, dataDistritos } = data;
                    if(status){
                        $sle_repindview_distr.html(`${dataDistritos}`);
                    }
                })
                .fail((jqXHR, statusText) => {
                    fn_errorJqXHR(jqXHR, statusText);
                });
            }
        });

        $sle_repindview_distr.change(function (e) {
            e.preventDefault();

            codDis = $(this).val();

            if(codDep){
                $.ajax({
                    url: `${base_url}localidad`,
                    type: "POST",
                    data: {codDis: codDis},
                    dataType: "JSON",
                })
                .done((data) => {
                    const { status, dataLocalidad } = data;
                    if(status){
                        $sle_repindview_locali.html(`${dataLocalidad}`);
                    }
                })
                .fail((jqXHR, statusText) => {
                    fn_errorJqXHR(jqXHR, statusText);
                });
            }
        });

        let codLoc;
        $sle_repindview_locali.change(function (e) {
            e.preventDefault();
            codLoc = $(this).val();
            $lnk_ind_generar.css({'visibility': 'hidden'});
        });

        $btn_ind_buscar.click(function (e) { 
            e.preventDefault();

            const fini = $dte_ind_view_fechaini.val();
            const ffin = $dte_ind_view_fechafin.val();

            if(codLoc && fini && ffin){
                $lnk_ind_generar.css({'visibility': 'visible'});
                const newUrl = `${base_url}reportes/indices/xls/${codLoc}/${fini}/${ffin}`;
                $lnk_ind_generar.prop('href', newUrl);

            }else{
                Toast.fire({
                    icon: 'warning',
                    title: `Debes seleccionar una localidad y fechas!!`
                })
            }

        });

    </script>

<?= $this->endSection() ?>