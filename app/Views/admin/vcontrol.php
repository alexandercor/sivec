<?= $this->extend('layout/vlayout') ?>
<!--  -->
<?= $this->section('page_title') ?> Control | <?= SYS_TITLE; ?> <?= $this->endSection() ?>

<?= $this->section('contenido') ?>

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><i class="fas fa-sliders-h"></i> Control </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('home')?>">Inicio</a></li>
              <li class="breadcrumb-item active">Control</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
        <div class="container-fluid" id="div_overlay_con">
            <!-- <div class="loading"></div> -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-navy">
                        <div class="card-body card-navy card-outline">
                            <div class="alert alert-light" id="" role="alert">
                                <h5 class="alert-heading">Aviso!</h5>
                                <p><i class="fas fa-exclamation-triangle"></i> Selecciona un sector para poder observar la ubicación de los supervisores.</p>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="sle_conview_region">Region</label>
                                        <select name="sle_conview_region" id="sle_conview_region" class="form-control">
                                            <option value="#">Selecciona una región</option>
                                            <option value="MQ--">Costa</option>
                                            <option value="Mg--">Sierra</option>
                                            <option value="Mw--">Selva</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="sle_conview_depa">Departamento</label>
                                        <select name="sle_conview_depa" id="sle_conview_depa" class="form-control">
                                            <option value="#">Selecciona un departamento</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="sle_conview_prov">Provincia</label>
                                        <select name="sle_conview_prov" id="sle_conview_prov" class="form-control">
                                            <option value="#">Selecciona una provincia</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="sle_conview_distr">Distrito</label>
                                        <select name="sle_conview_distr" id="sle_conview_distr" class="form-control">
                                            <option value="#">Selecciona una distrito</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="sle_conview_locali">Localidad</label>
                                        <select name="sle_conview_locali" id="sle_conview_locali" class="form-control">
                                            <option value="#">Selecciona una localidad</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="sle_conview_sector">Sector</label>
                                        <select name="sle_conview_sector" id="sle_conview_sector" class="form-control">
                                            <option value="#">Selecciona una sector</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="row d-flex justify-content-end">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="">.</label>
                                                <button type="button" id="btn_buscar" class="btn btn-primary btn-block">Buscar</button>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">

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
    $(() => {

    })

    let codReg, codDep, codProv, codDis, codLoc, codSec;

    const objSelect = {
        'sleSec' : '#sle_conview_sector',
        'sleLoc' : '#sle_conview_locali',
        'sleDis' : '#sle_conview_distr',
        'slePro' : '#sle_conview_prov',
        'sleDep' : '#sle_conview_depa',
        'sleReg' : '#sle_conview_region'
    }
    const keys = Object.keys(objSelect);
    const countKeys = keys.length;
    
    const fn_limpiar_select = (counIte) =>{
        for (let i = 0; i < counIte; i++) {
            let propiedad = keys[i];
            $(`${objSelect[propiedad]}`).empty();
        }
    }

    $('#sle_conview_region').change(function (e) {
        e.preventDefault();
        fn_limpiar_select(5);
        // $('#sle_conview_depa').empty();
        codReg = $(this).val();
        if(codReg){
            $.ajax({
                url: `${base_url}departamentos`,
                type: "POST",
                data: {codReg: codReg},
                dataType: "JSON",
                beforeSend: (()=> {
                    // $('#div_overlay_con').html("<div class='loading'></div>");
                }),
            })
            .done((data) => {
                // $('.loading').remove();
                const { status, dataDepartamentos } = data;
                if(status){
                    $('#sle_conview_depa').html(`${dataDepartamentos}`);
                }
            })
            .fail((jqXHR, statusText) => {
                fn_errorJqXHR(jqXHR, statusText);
            });
        }
    });

    $('#sle_conview_depa').change(function (e) {
        e.preventDefault();
        fn_limpiar_select(4);
        // $('#sle_conview_prov').empty();
        codDep = $(this).val();

        if(codDep){
            $.ajax({
                url: `${base_url}provincias`,
                type: "POST",
                data: {codDep: codDep},
                dataType: "JSON",
                beforeSend: (()=> {
                    // $('#div_overlay_con').html("<div class='loading'></div>");
                }),
            })
            .done((data) => {
                // $('.loading').remove();
                const { status, dataProvincias } = data;
                if(status){
                    $('#sle_conview_prov').html(`${dataProvincias}`);
                }
            })
            .fail((jqXHR, statusText) => {
                fn_errorJqXHR(jqXHR, statusText);
            });
        }
    });

    $('#sle_conview_prov').change(function (e) {
        e.preventDefault();
        fn_limpiar_select(3);
        // $('#sle_conview_distr').empty();
        codProv = $(this).val();

        if(codDep){
            $.ajax({
                url: `${base_url}distritos`,
                type: "POST",
                data: {codProv: codProv},
                dataType: "JSON",
                beforeSend: (()=> {
                    // $('#div_overlay_con').html("<div class='loading'></div>");
                }),
            })
            .done((data) => {
                // $('.loading').remove();
                const { status, dataDistritos } = data;
                if(status){
                    $('#sle_conview_distr').html(`${dataDistritos}`);
                }
            })
            .fail((jqXHR, statusText) => {
                fn_errorJqXHR(jqXHR, statusText);
            });
        }
    });

    $('#sle_conview_distr').change(function (e) {
        e.preventDefault();
        fn_limpiar_select(2);
        // $('#sle_conview_locali').empty();
        codDis = $(this).val();

        if(codDep){
            $.ajax({
                url: `${base_url}localidad`,
                type: "POST",
                data: {codDis: codDis},
                dataType: "JSON",
                beforeSend: (()=> {
                    // $('#div_overlay_con').html("<div class='loading'></div>");
                }),
            })
            .done((data) => {
                // $('.loading').remove();
                const { status, dataLocalidad } = data;
                if(status){
                    $('#sle_conview_locali').html(`${dataLocalidad}`);
                }
            })
            .fail((jqXHR, statusText) => {
                fn_errorJqXHR(jqXHR, statusText);
            });
        }
    });

    $('#sle_conview_locali').change(function (e) {
        e.preventDefault();
        fn_limpiar_select(1);
        // $('#sle_conview_sector').empty();
        codLoc = $(this).val();

        if(codDep){
            $.ajax({
                url: `${base_url}sector`,
                type: "POST",
                data: {codLoc: codLoc},
                dataType: "JSON",
                beforeSend: (()=> {
                    // $('#div_overlay_con').html("<div class='loading'></div>");
                }),
            })
            .done((data) => {
                // $('.loading').remove();
                const { status, dataSector } = data;
                if(status){
                    $('#sle_conview_sector').html(`${dataSector}`);
                }
            })
            .fail((jqXHR, statusText) => {
                fn_errorJqXHR(jqXHR, statusText);
            });
        }
    });


    $('#btn_buscar').click(() => {
        console.log(codReg)
    })
  </script>

<?= $this->endSection() ?>