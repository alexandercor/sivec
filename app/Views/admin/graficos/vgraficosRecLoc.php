<?= $this->extend('layout/vlayout') ?>
<!--  -->
<?= $this->section('page_title') ?> Gráficos - Localidad | <?= SYS_TITLE; ?> 
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><i class="fas fa-sliders-h"></i> Gráficos - Localidad</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('home')?>">Inicio</a></li>
              <li class="breadcrumb-item active">Gráficos - Localidad</li>
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
                                <li class="nav-item"><a class="nav-link active" href="#tabloc" data-toggle="tab"><i class="fas fa-file-excel"></i> Gráficos</a></li>
                                <!-- <li class="nav-item"><a class="nav-link" href="#tabadd" data-toggle="tab">Agregar</a></li> -->
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tabloc">

                                    <div class="row">
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="sle_gralocview_region">Region</label>
                                                <select id="sle_gralocview_region" class="form-control" data-send="view">
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
                                                <label for="sle_gralocview_depa">Departamento</label>
                                                <select id="sle_gralocview_depa" class="form-control" data-send="view">
                                                    <option value="">Selecciona un departamento</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="sle_gralocview_prov">Provincia</label>
                                                <select id="sle_gralocview_prov" class="form-control" data-send="view">
                                                    <option value="">Selecciona una provincia</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="sle_gralocview_distr">Distrito</label>
                                                <select id="sle_gralocview_distr" class="form-control" data-send="view">
                                                    <option value="">Selecciona una distrito</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row d-flex align-items-end">
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="sle_gralocview_locali">Localidad</label>
                                                <select id="sle_gralocview_locali" class="form-control" data-send="view">
                                                    <option value="">Selecciona una localidad</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="dte_gralocview_fechaini">Fecha Inicia</label>
                                                <input type="date" class="form-control form-control" id="dte_gralocview_fechaini">
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="dte_gralocview_fechafin">Fecha Fin</label>
                                                <input type="date" class="form-control form-control" id="dte_gralocview_fechafin">
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <botton type="botton" id="btn_grafloc_generar" class="btn btn-primary btn-block"> <i class="fas fa-undo-alt"></i> Generar Gráfico</botton>
                                            </div>                    
                                        </div>                
                                    </div>
                                    <hr>
                                    <div class="row justify-content-center">
                                        <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-xs-12">
                                            <!-- <div id="myBarChartRecLoc"></div> -->
                                            <canvas id="myBarChartRecLoc" width="200" height="100"></canvas>
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
            $sle_gralocview_region = $('#sle_gralocview_region');
            $sle_gralocview_depa = $('#sle_gralocview_depa');
            $sle_gralocview_prov = $('#sle_gralocview_prov');
            $sle_gralocview_distr = $('#sle_gralocview_distr');
            $sle_gralocview_locali = $('#sle_gralocview_locali');
            $dte_gralocview_fechaini = $('#dte_gralocview_fechaini');
            $dte_gralocview_fechafin = $('#dte_gralocview_fechafin');
            $btn_grafloc_generar = $('#btn_grafloc_generar');
            
        })

        $sle_gralocview_region = $('#sle_gralocview_region');
        $sle_gralocview_depa = $('#sle_gralocview_depa');
        $sle_gralocview_prov = $('#sle_gralocview_prov');
        $sle_gralocview_distr = $('#sle_gralocview_distr');
        $sle_gralocview_locali = $('#sle_gralocview_locali');
        $dte_gralocview_fechaini = $('#dte_gralocview_fechaini');
        $dte_gralocview_fechafin = $('#dte_gralocview_fechafin');
        $btn_grafloc_generar = $('#btn_grafloc_generar');

        $sle_gralocview_region.change(function (e) {
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
                        $sle_gralocview_depa.html(`${dataDepartamentos}`);
                    }
                })
                .fail((jqXHR, statusText) => {
                    fn_errorJqXHR(jqXHR, statusText);
                });
            }
        });

        $sle_gralocview_depa.change(function (e) {
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
                        $sle_gralocview_prov.html(`${dataProvincias}`);
                    }
                })
                .fail((jqXHR, statusText) => {
                    fn_errorJqXHR(jqXHR, statusText);
                });
            }
        });

        $sle_gralocview_prov.change(function (e) {
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
                        $sle_gralocview_distr.html(`${dataDistritos}`);
                    }
                })
                .fail((jqXHR, statusText) => {
                    fn_errorJqXHR(jqXHR, statusText);
                });
            }
        });

        $sle_gralocview_distr.change(function (e) {
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
                        $sle_gralocview_locali.html(`${dataLocalidad}`);
                    }
                })
                .fail((jqXHR, statusText) => {
                    fn_errorJqXHR(jqXHR, statusText);
                });
            }
        });

        $btn_grafloc_generar.click(function (e) { 
            e.preventDefault();
            const fini = $dte_gralocview_fechaini.val();
            const ffin = $dte_gralocview_fechafin.val();
            const codLoc = $sle_gralocview_locali.val();

            if(codLoc && fini && ffin){
                fn_getTotalActividades(codLoc, fini, ffin);

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
        const fn_genera_grafico = (totalActiSec) => {

            const ctx = document.getElementById('myBarChartRecLoc').getContext('2d');

            if (myBarChart) {
                myBarChart.destroy();
            }

            const backgroundColors = [
                'rgba(0, 123, 255, 0.7)',   
                'rgba(40, 167, 69, 0.7)',  
                'rgba(255, 193, 7, 0.7)',  
                'rgba(220, 53, 69, 0.7)',  
                'rgba(108, 117, 125, 0.7)'
            ];

            const borderColors = [
                'rgba(0, 123, 255, 1)',    
                'rgba(40, 167, 69, 1)',    
                'rgba(255, 193, 7, 1)',    
                'rgba(220, 53, 69, 1)',  
                'rgba(108, 117, 125, 1)' 
            ];

            myBarChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Control Focal', 'Vigilancia Aédica', 'Recuperación', 'Barrido  Focal', 'Otros'],
                    datasets: [{
                        label: 'Actividades por Localidad',
                        data: totalActiSec,
                        backgroundColor: backgroundColors,
                        borderColor: borderColors,
                        borderWidth: 1,
                        maxBarThickness: 40
                    }]
                },
                options: {
                    responsive: true,
                }
            });
        }

        const fn_getTotalActividades = (codLoc, fini, ffin) => {
            $('#myBarChartResponse').html('');
            
            $.ajax({
                url: `${base_url}graficos/localidad/actividades`,
                type: "POST",
                data: {codLoc: codLoc, fini: fini, ffin: ffin},
                dataType: "JSON",
                beforeSend: (()=> {
                    $('#div_overlay').loading({message: 'Cargando...'});
                }),
            })
            .done((data) => {
                $('#div_overlay').loading('stop');
                const { status, msg, totalesAct } = data;
                if(status){

                    let totalActiSec = Object.values(totalesAct);
                    fn_genera_grafico(totalActiSec);

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