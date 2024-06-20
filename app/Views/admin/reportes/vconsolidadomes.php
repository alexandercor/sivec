<?= $this->extend('layout/vlayout') ?>
<!--  -->
<?= $this->section('page_title') ?> Reportes - Consolidado | <?= SYS_TITLE; ?> 
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>
	<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><i class="fas fa-sliders-h"></i> Reportes - Consolidado Mensual de Vigilancia</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('home')?>">Inicio</a></li>
              <li class="breadcrumb-item active">Reportes - Consolidado</li>
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
                            
                        </div>
                        <div class="card-body">
                        	<div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="sle_repsecview_region">Region</label>
                                        <select id="sle_repsecview_region" class="form-control" data-send="view">
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
                                        <label for="sle_repsecview_depa">Departamento</label>
                                        <select id="sle_repsecview_depa" class="form-control" data-send="view">
                                            <option value="">Selecciona un departamento</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="sle_repsecview_prov">Provincia</label>
                                        <select id="sle_repsecview_prov" class="form-control" data-send="view">
                                            <option value="">Selecciona una provincia</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="sle_repsecview_distr">Distrito</label>
                                        <select id="sle_repsecview_distr" class="form-control" data-send="view">
                                            <option value="">Selecciona una distrito</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex align-items-end">
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="sle_repsecview_locali">Localidad</label>
                                        <select id="sle_repsecview_locali" class="form-control" data-send="view">
                                            <option value="">Selecciona una localidad</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="sle_insviewfechaini">Fecha inicia</label>
                                        <input type="date" name="sle_insviewfechaini" id="sle_insviewfechaini" class="form-control">
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="sle_insviewfechafin">Fecha fin</label>
                                        <input type="date" name="sle_insviewfechafin" id="sle_insviewfechafin" class="form-control">
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12 d-flex align-items-end">
                                    <div class="form-group w-100">
                                        <button type="button" id="btn_consolidado_generar" class="btn btn-primary w-100">
                                            <i class="fas fa-undo-alt"></i> Generar
                                        </button>
                                    </div>                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12 d-flex align-items-end">
                                    <div class="form-group">
                                    	<a href="#" id="btn_consolidado_generarxlsx" class="btn btn-success hidden">
                                    		<i class="fas fa-file-excel"></i> Consolidado Mes
                                    	</a>
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

<?= $this->section('javascript') ?>
	<script type="text/javascript">
        $(() => {
            $sle_repsecview_region = $('#sle_repsecview_region');
            $sle_repsecview_depa = $('#sle_repsecview_depa');
            $sle_repsecview_prov = $('#sle_repsecview_prov');
            $sle_repsecview_distr = $('#sle_repsecview_distr');
            $sle_repsecview_locali = $('#sle_repsecview_locali');
            $btn_consolidado_generar = $('#btn_consolidado_generar');
            $btn_consolidado_generarxlsx = $('#btn_consolidado_generarxlsx');
            
        })

        $sle_repsecview_region = $('#sle_repsecview_region');
        $sle_repsecview_depa = $('#sle_repsecview_depa');
        $sle_repsecview_prov = $('#sle_repsecview_prov');
        $sle_repsecview_distr = $('#sle_repsecview_distr');
        $sle_repsecview_locali = $('#sle_repsecview_locali');
        $sle_insviewfechaini = $('#sle_insviewfechaini');
        $sle_insviewfechafin = $('#sle_insviewfechafin');
        $btn_consolidado_generar = $('#btn_consolidado_generar');
        $btn_consolidado_generarxlsx = $('#btn_consolidado_generarxlsx');

		// $(document).ready(function() {
		// 	$('#btn_consolidado_generarxlsx').hide();
		// });
        $sle_repsecview_region.change(function (e) {
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
                        $sle_repsecview_depa.html(`${dataDepartamentos}`);
                    }
                })
                .fail((jqXHR, statusText) => {
                    fn_errorJqXHR(jqXHR, statusText);
                });
            }
        });

        $sle_repsecview_depa.change(function (e) {
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
                        $sle_repsecview_prov.html(`${dataProvincias}`);
                    }
                })
                .fail((jqXHR, statusText) => {
                    fn_errorJqXHR(jqXHR, statusText);
                });
            }
        });

        $sle_repsecview_prov.change(function (e) {
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
                        $sle_repsecview_distr.html(`${dataDistritos}`);
                    }
                })
                .fail((jqXHR, statusText) => {
                    fn_errorJqXHR(jqXHR, statusText);
                });
            }
        });

        $sle_repsecview_distr.change(function (e) {
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
                        $sle_repsecview_locali.html(`${dataLocalidad}`);
                    }
                })
                .fail((jqXHR, statusText) => {
                    fn_errorJqXHR(jqXHR, statusText);
                });
            }
        });

        let codLoc;
        $sle_repsecview_locali.change(function (e) {
            e.preventDefault();
            codLoc = $(this).val();
        });

		$btn_consolidado_generar.click(function(event) {
			const fechaInicio = $sle_insviewfechaini.val();
            const fechaFin = $sle_insviewfechafin.val();
            if(codLoc){
                if (fechaInicio !== "" & fechaFin !== "") {
                    
                    if (validateDates() == true) {
                        
                        $btn_consolidado_generarxlsx.css({'visibility': 'visible'});
                        const newUrl = `${base_url}reportes/consolidado-mes/xls/${codLoc}/${fechaInicio}/${fechaFin}`;
                        $btn_consolidado_generarxlsx.prop('href', newUrl);
                    }
                    
                } else {
                    Toast.fire({
                        icon: 'warning',
                        title: `Debes seleccionar las fechas`
                    })
                }

            }else{
                Toast.fire({
                    icon: 'warning',
                    title: `Debes seleccionar una localidad`
                })
            }

            
		});

		function validateDates() {
            const fechaInicio = $sle_insviewfechaini.val();
            const fechaFin = $sle_insviewfechafin.val();

            if (fechaInicio && fechaFin) {
                const dateInicio = new Date(fechaInicio);
                const dateFin = new Date(fechaFin);

                const mesInicio = dateInicio.getUTCMonth();
                const mesFin = dateFin.getUTCMonth();
                const añoInicio = dateInicio.getUTCFullYear();
                const añoFin = dateFin.getUTCFullYear();

                if (mesInicio === mesFin && añoInicio === añoFin) {
                    
                    return true;
                } else {
                    Toast.fire({
                        icon: 'warning',
                        title: `Las fechas deben pertenecer al mismo mes y año.`
                    })
                	
                    return false;
                }
            }
            return false;
        }

        $('#sle_repsecview_region, #sle_repsecview_depa, #sle_repsecview_prov, #sle_repsecview_distr, #sle_repsecview_locali').change(function(){
            $btn_consolidado_generarxlsx.css({'visibility': 'hidden'});
        })

        $('#sle_insviewfechaini, #sle_insviewfechafin').focus(function(e) {
        	$btn_consolidado_generarxlsx.css({'visibility': 'hidden'});
        });

        $('#sle_insviewfechaini, #sle_insviewfechafin').change(function() {
            validateDates();
            $btn_consolidado_generarxlsx.css({'visibility': 'hidden'});
        });

        $('#btn_consolidado_generar, #btn_consolidado_generarxlsx').click(function(e) {
            if (!validateDates()) {
                e.preventDefault();
            }
        });
	</script>
<?= $this->endSection() ?>