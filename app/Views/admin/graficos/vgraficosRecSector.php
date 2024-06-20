<?= $this->extend('layout/vlayout') ?>
<!--  -->
<?= $this->section('page_title') ?> Gráficos - Recipientes por Sector | <?= SYS_TITLE; ?> 
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><i class="fas fa-sliders-h"></i> Gráficos - Recipientes por Sector</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('home')?>">Inicio</a></li>
              <li class="breadcrumb-item active">Gráficos - Recipientes por Sector</li>
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
                                <li class="nav-item"><a class="nav-link active" href="#tabloc" data-toggle="tab"><i class="fas fa-file-excel"></i> Gráficos</a></li>
                            </ul> -->
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tabloc">

                                    <div class="row">
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="sle_grasecview_region">Region</label>
                                                <select id="sle_grasecview_region" class="form-control" data-send="view">
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
                                                <label for="sle_grasecview_depa">Departamento</label>
                                                <select id="sle_grasecview_depa" class="form-control" data-send="view">
                                                    <option value="">Selecciona un departamento</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="sle_grasecview_prov">Provincia</label>
                                                <select id="sle_grasecview_prov" class="form-control" data-send="view">
                                                    <option value="">Selecciona una provincia</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="sle_grasecview_distr">Distrito</label>
                                                <select id="sle_grasecview_distr" class="form-control" data-send="view">
                                                    <option value="">Selecciona una distrito</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row d-flex align-items-end">
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="sle_grasecview_locali">Localidad</label>
                                                <select id="sle_grasecview_locali" class="form-control" data-send="view">
                                                    <option value="">Selecciona una localidad</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="sle_grasecview_sec">Sector</label>
                                                <select id="sle_grasecview_sec" class="form-control" data-send="view">
                                                    <option value="">Selecciona un sector</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="dte_grasecview_fechaini">Fecha Inicia</label>
                                                <input type="date" class="form-control form-control" id="dte_grasecview_fechaini">
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="dte_grasecview_fechafin">Fecha Fin</label>
                                                <input type="date" class="form-control form-control" id="dte_grasecview_fechafin">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <botton type="botton" id="btn_grafsec_generar" class="btn btn-primary btn-block"> <i class="fas fa-undo-alt"></i> Generar Gráfico</botton>
                                            </div>                    
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row justify-content-center">
                                        <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-xs-12">
                                            <!-- <div id="myBarChartRecSec"></div> -->
                                            <canvas id="myBarChartRecSec" width="200" height="100"></canvas>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div id="myBarChartResponse"></div>
                                        </div>

                                    </div>
                                    
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
            $sle_grasecview_region = $('#sle_grasecview_region');
            $sle_grasecview_depa = $('#sle_grasecview_depa');
            $sle_grasecview_prov = $('#sle_grasecview_prov');
            $sle_grasecview_distr = $('#sle_grasecview_distr');
            $sle_grasecview_locali = $('#sle_grasecview_locali');
            $sle_grasecview_sec = $('#sle_grasecview_sec');
            $dte_grasecview_fechaini = $('#dte_grasecview_fechaini');
            $dte_grasecview_fechafin = $('#dte_grasecview_fechafin');
            $btn_grafsec_generar = $('#btn_grafsec_generar');
            
        })

        $sle_grasecview_region = $('#sle_grasecview_region');
        $sle_grasecview_depa = $('#sle_grasecview_depa');
        $sle_grasecview_prov = $('#sle_grasecview_prov');
        $sle_grasecview_distr = $('#sle_grasecview_distr');
        $sle_grasecview_locali = $('#sle_grasecview_locali');
        $sle_grasecview_sec = $('#sle_grasecview_sec');
        $dte_grasecview_fechaini = $('#dte_grasecview_fechaini');
        $dte_grasecview_fechafin = $('#dte_grasecview_fechafin');
        $btn_grafsec_generar = $('#btn_grafsec_generar');

        $sle_grasecview_region.change(function (e) {
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
                        $sle_grasecview_depa.html(`${dataDepartamentos}`);
                    }
                })
                .fail((jqXHR, statusText) => {
                    fn_errorJqXHR(jqXHR, statusText);
                });
            }
        });

        $sle_grasecview_depa.change(function (e) {
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
                        $sle_grasecview_prov.html(`${dataProvincias}`);
                    }
                })
                .fail((jqXHR, statusText) => {
                    fn_errorJqXHR(jqXHR, statusText);
                });
            }
        });

        $sle_grasecview_prov.change(function (e) {
            e.preventDefault();
            
            codProv = $(this).val();

            if(codProv){
                $.ajax({
                    url: `${base_url}distritos`,
                    type: "POST",
                    data: {codProv: codProv},
                    dataType: "JSON",
                })
                .done((data) => {
                    const { status, dataDistritos } = data;
                    if(status){
                        $sle_grasecview_distr.html(`${dataDistritos}`);
                    }
                })
                .fail((jqXHR, statusText) => {
                    fn_errorJqXHR(jqXHR, statusText);
                });
            }
        });

        $sle_grasecview_distr.change(function (e) {
            e.preventDefault();

            codDis = $(this).val();

            if(codDis){
                $.ajax({
                    url: `${base_url}localidad`,
                    type: "POST",
                    data: {codDis: codDis},
                    dataType: "JSON",
                })
                .done((data) => {
                    const { status, dataLocalidad } = data;
                    if(status){
                        $sle_grasecview_locali.html(`${dataLocalidad}`);
                    }
                })
                .fail((jqXHR, statusText) => {
                    fn_errorJqXHR(jqXHR, statusText);
                });
            }
        });

        let codLoc;
        $sle_grasecview_locali.change(function (e) {
            codLoc = $(this).val();

            if(codLoc){
                $.ajax({
                    url: `${base_url}sector`,
                    type: "POST",
                    data: {codLoc: codLoc},
                    dataType: "JSON",
                })
                .done((data) => {
                    const { status, dataSector } = data;
                    if(status){
                        $sle_grasecview_sec.html(`${dataSector}`);
                    }
                })
                .fail((jqXHR, statusText) => {
                    fn_errorJqXHR(jqXHR, statusText);
                });
            }
        });
        
        // let codSec;
        // $sle_grasecview_sec.change(function (e) {
        //     e.preventDefault();
        //     codSec = $(this).val();
        // });

        $btn_grafsec_generar.click(function (e) { 
            e.preventDefault();
            const fini = $dte_grasecview_fechaini.val();
            const ffin = $dte_grasecview_fechafin.val();
            const codSec = $sle_grasecview_sec.val();

            if(codSec && fini && ffin){
                fn_getTotalActividades(codSec, fini, ffin);

            }else{
                if (myBarChart) {
                    myBarChart.destroy();
                }
                Toast.fire({
                    icon: 'warning',
                    title: `Debes seleccionar los campos!!`
                })
            }
        });

        let myBarChart;
        const fn_genera_grafico = (totalRecSec) => {

            const ctx = document.getElementById('myBarChartRecSec').getContext('2d');

            if (myBarChart) {
                myBarChart.destroy();
            }

            const recipientes = ['TANQUE ELEVADO', 'TANQUE BAJO', 'CILINDROS', 'SANSON', 'TINAJAS ', 'FLOREROS', 'BALDES', 'BIDONES GALONERAS', 'OTROS', 'INSERVIBLES', 'OLLAS'];

            myBarChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: recipientes,
                    datasets: [{
                        label: 'Recipientes por Sector',
                        data: totalRecSec,
                        backgroundColor: 'rgba(0, 123, 255, 0.7)',
                        borderColor: 'rgba(0, 123, 255, 1)',
                        borderWidth: 1,
                        maxBarThickness: 40
                    }]
                },
                options: {
                    responsive: true,
                }
            });
        }

        const fn_getTotalActividades = (codSec, fini, ffin) => {
            $('#myBarChartResponse').html('');
            
            $.ajax({
                url: `${base_url}graficos/sector/recixsec`,
                type: "POST",
                data: {codSec: codSec, fini: fini, ffin: ffin},
                dataType: "JSON",
                beforeSend: (()=> {
                    $('#div_overlay').loading({message: 'Cargando...'});
                }),
            })
            .done((data) => {
                $('#div_overlay').loading('stop');
                const { status, msg, totalesAct } = data;
                if(status){

                    let totalRecSec = Object.values(totalesAct);
                    fn_genera_grafico(totalRecSec);

                }else{
                    if (myBarChart) {
                        myBarChart.destroy();
                    }
                    $('#myBarChartResponse').html(`<div class="alert alert-warning" role="alert">
                        <i class="fas fa-exclamation-triangle"></i> ${msg}
                    </div>`);
                }
            })
            .fail((jqXHR, statusText) => {
                fn_errorJqXHR(jqXHR, statusText);
            });
        }
       
    </script>

<?= $this->endSection() ?>