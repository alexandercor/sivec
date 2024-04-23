<?= $this->extend('layout/vlayout') ?>
<!--  -->
<?= $this->section('page_title') ?> Essalud | <?= SYS_TITLE; ?> <?= $this->endSection() ?>

<?= $this->section('contenido') ?>

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><i class="fas fa-sliders-h"></i> Essalud</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('home')?>">Inicio</a></li>
              <li class="breadcrumb-item active">Essalud</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
        <div class="container-fluid" id="div_overlay_act">
            <div class="card card-navy card-outline">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="sle_essview_region">Region</label>
                                <select id="sle_essview_region" class="form-control">
                                    <option value="#">Selecciona una región</option>
                                    <option value="MQ--">Costa</option>
                                    <option value="Mg--">Sierra</option>
                                    <option value="Mw--">Selva</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="sle_essview_depa">Departamento</label>
                                <select id="sle_essview_depa" class="form-control">
                                    <option value="#">Selecciona un departamento</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="sle_essview_prov">Provincia</label>
                                <select id="sle_essview_prov" class="form-control">
                                    <option value="#">Selecciona una provincia</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="sle_essview_distr">Distrito</label>
                                <select id="sle_essview_distr" class="form-control">
                                    <option value="#">Selecciona una distrito</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="sle_essview_locali">Localidad</label>
                                <select id="sle_essview_locali" class="form-control">
                                    <option value="#">Selecciona una localidad</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="sle_essview_sector">Sector</label>
                                <select id="sle_essview_sector" class="form-control">
                                    <option value="#">Selecciona una sector</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="" class="color_white">.</label>
                                <button type="button" id="btn_buscar_ess" class="btn btn-primary btn-block rounded-pill">Buscar</button>
                            </div> 
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="" class="color_white">.</label>
                                <button type="button" class="btn btn-success btn-block rounded-pill" data-toggle="modal" data-target="#mdl_essalud">Agregar</button>
                            </div> 
                        </div>
                    </div>
                    <hr class="mt-0">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <table id="tbl_essalud" class="table table-striped table-bordered table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Centro de salud</th>
                                        <th>Sector</th>
                                        <th>Acc.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="modal fade" id="mdl_essalud" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="frm_actidividad" action="<?= base_url(); ?>actividades/add" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Actividad</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Denominación</label>
                                    <input type="text" class="form-control" id="txt_mdlviewact_activ" name="txt_mdlviewact_activ" placeholder="Denominación">
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        <div id="div_response"></div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

<?= $this->endSection() ?>

<?= $this->section('javascript') ?>

  <script type='text/javascript'>
    $(() => {
        fn_getDataEssalud();
    })

    const div_overlay_act = 'div_overlay_act';
    let codReg, codDep, codProv, codDis, codLoc, codSec;

    const objSelect = {
        'sleSec' : '#sle_essview_sector',
        'sleLoc' : '#sle_essview_locali',
        'sleDis' : '#sle_essview_distr',
        'slePro' : '#sle_essview_prov',
        'sleDep' : '#sle_essview_depa',
        'sleReg' : '#sle_essview_region'
    }
    const keys = Object.keys(objSelect);
    const countKeys = keys.length;
    
    const fn_limpiar_select = (counIte) =>{
        for (let i = 0; i < counIte; i++) {
            let propiedad = keys[i];
            $(`${objSelect[propiedad]}`).empty();
        }
    }

    $('#sle_essview_region').change(function (e) {
        e.preventDefault();
        fn_limpiar_select(5);

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
                    $('#sle_essview_depa').html(`${dataDepartamentos}`);
                }
            })
            .fail((jqXHR, statusText) => {
                fn_errorJqXHR(jqXHR, statusText);
            });
        }
    });

    $('#sle_essview_depa').change(function (e) {
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
                    $('#sle_essview_prov').html(`${dataProvincias}`);
                }
            })
            .fail((jqXHR, statusText) => {
                fn_errorJqXHR(jqXHR, statusText);
            });
        }
    });

    $('#sle_essview_prov').change(function (e) {
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
                    $('#sle_essview_distr').html(`${dataDistritos}`);
                }
            })
            .fail((jqXHR, statusText) => {
                fn_errorJqXHR(jqXHR, statusText);
            });
        }
    });

    $('#sle_essview_distr').change(function (e) {
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
                    $('#sle_essview_locali').html(`${dataLocalidad}`);
                }
            })
            .fail((jqXHR, statusText) => {
                fn_errorJqXHR(jqXHR, statusText);
            });
        }
    });

    $('#sle_essview_locali').change(function (e) {
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
                    $('#sle_essview_sector').html(`${dataSector}`);
                }
            })
            .fail((jqXHR, statusText) => {
                fn_errorJqXHR(jqXHR, statusText);
            });
        }
    });

    $('#sle_essview_sector').change(function (e){
        codSec = $(this).val();
    });

    function fn_getDataEssalud(){

        const objData = { codSec : codSec };
        $.ajax({
            url: `${base_url}esssalud/list`,
            type: "POST",
            data: objData,
            dataType: "JSON",
        })
        .done(function(data){
            const { status, dataEssalud } = data;
            if(status){
                $('#tbl_essalud tbody').html(`${dataEssalud}`);
            }
        })
        .fail(function(jqXHR, statusText){
            fn_errorJqXHR(jqXHR, statusText);
        });
    }

    $('#btn_buscar_ess').click(function(){
        fn_getDataEssalud();
    })

    $('#frm_actidividad').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: `${base_url}actividades/add`,
            type: $(this).attr('method'),
            data: $(this).serialize(),
            dataType: "JSON",
        })
        .done(function(data){
            const { status, msg, errors } = data;
            if(status){
                $('#div_response').html(`<h4><i class="fas fa-check-circle"></i> ${msg} </h4>`);
                setTimeout(() => {
                    $('#mdl_actividad').modal('hide');   
                    window.location.reload();
                }, 4000);
            }
        })
        .fail(function(jqXHR, statusText){
            fn_errorJqXHR(jqXHR, statusText);
        });
        return false;
    });

    
  </script>

<?= $this->endSection() ?>