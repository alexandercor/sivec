<?= $this->extend('layout/vlayout') ?>
<!--  -->
<?= $this->section('page_title') ?> Establecimiento de salud | <?= SYS_TITLE; ?> <?= $this->endSection() ?>

<?= $this->section('contenido') ?>

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><i class="fas fa-sliders-h"></i> Establecimiento de salud</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('home')?>">Inicio</a></li>
              <li class="breadcrumb-item active">Establecimiento de salud</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-navy card-outline">
                        <div class="card-header p-0">
                            <ul id="tab_es" class="nav nav-pills ml-auto p-2">
                                <li class="nav-item"><a class="nav-link active" href="#tabes" data-toggle="tab">Lista</a></li>
                                <li class="nav-item"><a class="nav-link" href="#tabadd" data-toggle="tab">Agregar</a></li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tabes">
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="sle_essview_region">Region</label>
                                                <select id="sle_essview_region" class="form-control" data-send="view">
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
                                                <label for="sle_essview_depa">Departamento</label>
                                                <select id="sle_essview_depa" class="form-control" data-send="view">
                                                    <option value="">Selecciona un departamento</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="sle_essview_prov">Provincia</label>
                                                <select id="sle_essview_prov" class="form-control" data-send="view">
                                                    <option value="">Selecciona una provincia</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="sle_essview_distr">Distrito</label>
                                                <select id="sle_essview_distr" class="form-control" data-send="view">
                                                    <option value="">Selecciona una distrito</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="sle_essview_locali">Localidad</label>
                                                <select id="sle_essview_locali" class="form-control" data-send="view">
                                                    <option value="">Selecciona una localidad</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="sle_essview_sector">Sector</label>
                                                <select id="sle_essview_sector" class="form-control" data-send="view">
                                                    <option value="">Selecciona una sector</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="" class="color_white">.</label>
                                                <button type="button" id="btn_buscar_ess" class="btn btn-primary btn-block">Buscar</button>
                                            </div> 
                                        </div>
                                    </div>
                                    <hr class="mt-0">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
                                            <table id="tbl_essalud" class="table table-striped table-bordered table-sm table-hover projects">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Centro de salud</th>
                                                        <th>Sector</th>
                                                        <th>Localidad</th>
                                                        <th>Distrito</th>
                                                        <th>Provincia</th>
                                                        <th>Departamento</th>
                                                        <th>Región</th>
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
                                        <form id="frm_es" action="<?= base_url(); ?>esssalud/add" method="POST">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div id="div_errors" class="error_danger"></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <input type="hidden" name="txt_esscrud_esta" id="txt_esscrud_esta" value="MQ--">

                                                    <input type="hidden" name="txt_esscrud_keyeess" id="txt_esscrud_keyeess">

                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label for="sle_esscrud_region">Region</label>
                                                            <select id="sle_esscrud_region" class="form-control" data-send="crud">
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
                                                            <label for="sle_esscrud_depa">Departamento</label>
                                                            <select id="sle_esscrud_depa" class="form-control" data-send="crud">
                                                                <option value="">Selecciona un departamento</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label for="sle_esscrud_prov">Provincia</label>
                                                            <select id="sle_esscrud_prov" class="form-control" data-send="crud">
                                                                <option value="">Selecciona una provincia</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label for="sle_esscrud_distr">Distrito</label>
                                                            <select id="sle_esscrud_distr" class="form-control" data-send="crud">
                                                                <option value="">Selecciona una distrito</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label for="sle_esscrud_locali">Localidad</label>
                                                            <select id="sle_esscrud_locali" class="form-control" data-send="crud">
                                                                <option value="">Selecciona una localidad</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label for="sle_esscrud_sector">Sector</label>
                                                            <select id="sle_esscrud_sector" name="sle_esscrud_sector" class="form-control" data-send="crud">
                                                                <option value="">Selecciona una sector</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label for="txt_esscrud_eess" >Centro de salud</label>
                                                            <input type="text" class="form-control text-uppercase" id="txt_esscrud_eess" name="txt_esscrud_eess"   placeholder="Centro de salud">
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

<?= $this->section('javascript') ?>

  <script type='text/javascript'>
    $(() => {
        fn_getDataEssalud();
    })

    const div_overlay_es = 'div_overlay_es';
    let codReg, codDep, codProv, codDis, codLoc, codSec;

    // const objSelect = {
    //     'sleSec' : '#sle_essview_sector',
    //     'sleLoc' : '#sle_essview_locali',
    //     'sleDis' : '#sle_essview_distr',
    //     'slePro' : '#sle_essview_prov',
    //     'sleDep' : '#sle_essview_depa',
    //     'sleReg' : '#sle_essview_region'
    // }
    // const keys = Object.keys(objSelect);
    // const countKeys = keys.length;
    
    // const fn_limpiar_select1 = (counIte) =>{
    //     for (let i = 0; i < counIte; i++) {
    //         let propiedad = keys[i];
    //         $(`${objSelect[propiedad]}`).empty();
    //     }
    // }

    const objSelectsData = {
        view : {
            sleSec : '#sle_essview_sector',
            sleLoc : '#sle_essview_locali',
            sleDis : '#sle_essview_distr',
            slePro : '#sle_essview_prov',
            sleDep : '#sle_essview_depa',
            sleReg : '#sle_essview_region'
        },
        crud : {
            sleSec : '#sle_esscrud_sector',
            sleLoc : '#sle_esscrud_locali',
            sleDis : '#sle_esscrud_distr',
            slePro : '#sle_esscrud_prov',
            sleDep : '#sle_esscrud_depa',
            sleReg : '#sle_esscrud_region'
        },
    };

    const selecView = objSelectsData.view,
    selecCrud = objSelectsData.crud;


    const fn_limpiar_select = (counIte, keySend) =>{
        const keySendObject = objSelectsData[keySend],
        keySendCildremObject = Object.keys(keySendObject);

        for (let i = 0; i < counIte; i++) {
            let propiedad = keySendCildremObject[i];
            $(`${keySendObject[propiedad]}`).empty();
        }
    }

    $(`${selecView.sleReg}, ${selecCrud.sleReg}`).change(function (e) {
        e.preventDefault();
        
        const typeSend = $(this).data('send'),
            idSelect = objSelectsData[typeSend].sleDep;
            fn_limpiar_select(5, typeSend);

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
                    $(`${idSelect}`).html(`${dataDepartamentos}`);
                }
            })
            .fail((jqXHR, statusText) => {
                fn_errorJqXHR(jqXHR, statusText);
            });
        }
    });

    $(`${selecView.sleDep}, ${selecCrud.sleDep}`).change(function (e) {
        e.preventDefault();
        
        const typeSend = $(this).data('send'),
        idSelect = objSelectsData[typeSend].slePro;
        fn_limpiar_select(4, typeSend);

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
                    $(`${idSelect}`).html(`${dataProvincias}`);
                }
            })
            .fail((jqXHR, statusText) => {
                fn_errorJqXHR(jqXHR, statusText);
            });
        }
    });

    $(`${selecView.slePro}, ${selecCrud.slePro}`).change(function (e) {
        e.preventDefault();
        
        const typeSend = $(this).data('send'),
            idSelect = objSelectsData[typeSend].sleDis;
            fn_limpiar_select(3, typeSend);

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
                    $(`${idSelect}`).html(`${dataDistritos}`);
                }
            })
            .fail((jqXHR, statusText) => {
                fn_errorJqXHR(jqXHR, statusText);
            });
        }
    });

    $(`${selecView.sleDis}, ${selecCrud.sleDis}`).change(function (e) {
        e.preventDefault();
        
        const typeSend = $(this).data('send'),
            idSelect = objSelectsData[typeSend].sleLoc;
            fn_limpiar_select(2, typeSend);

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
                    $(`${idSelect}`).html(`${dataLocalidad}`);
                }
            })
            .fail((jqXHR, statusText) => {
                fn_errorJqXHR(jqXHR, statusText);
            });
        }
    });

    $(`${selecView.sleLoc}, ${selecCrud.sleLoc}`).change(function (e) {
        e.preventDefault();
        
        const typeSend = $(this).data('send'),
            idSelect = objSelectsData[typeSend].sleSec;
            fn_limpiar_select(1, typeSend);

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
                    $(`${idSelect}`).html(`${dataSector}`);
                }
            })
            .fail((jqXHR, statusText) => {
                fn_errorJqXHR(jqXHR, statusText);
            });
        }
    });

    $(`${selecView.sleSec}, ${selecCrud.sleSec}`).change(function (e){
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

    $('#frm_es').submit(function (e) {
        $('#div_errors').html('');

        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: $(this).serialize(),
            dataType: "JSON",
        })
        .done(function(data){
            $('#div_errors').empty();
            const { status, msg, errors } = data;
            if(status){
                $('#div_response').html(`<h4><i class="fas fa-check-circle"></i> ${msg} </h4>`);
                setTimeout(() => {
                    window.location.reload();
                }, 4000);
            }else{
                let items = '';
                for(const key in errors){
                    items += `<p>${errors[key]}</p>`; 
                }
                $('#div_errors').html(`<div class="alert">${items}</div>`);
            }
        })
        .fail(function(jqXHR, statusText){
            fn_errorJqXHR(jqXHR, statusText);
        });
        return false;
    });

    $('#tab_es a[href="#tabes"]').click(function(){
        $('#tab_es a[href="#tabadd"]').text('Agregar');
        $('#frm_es')[0].reset();
    })

    $(document).on('click', '.btn_eess_edit', function() {

        $('#tab_es a[href="#tabadd"]').text('Editar')

        const keyEst = $(this).data('keyest'),
            keyEess = $(this).data('keyeess'),
            eess    = $(this).data('eess'),
            keySec  = $(this).data('keysec');

        if(keyEst === 'Mg--' && keyEess && eess && keySec){
            
            $.ajax({
                url: `${base_url}ubigeo/sector`,
                type: "POST",
                data: {keySector: keySec},
                dataType: "JSON",
                success: function (data) {
                    const { status, dataSectores } = data;
                    if(status){
                        // $('#sle_esscrud_region').val(dataSectores.key_reg);
                        // $('#sle_esscrud_depa').val(dataSectores.key_dep);
                        // $('#sle_esscrud_prov').val(dataSectores.key_pro);
                    }
                }
            });

            $('#txt_esscrud_esta').val(keyEst);
            $('#txt_esscrud_keyeess').val(keyEess);
            $('#txt_esscrud_eess').val(eess);
            // $('#sle_esscrud_sector').val(keySec);
            $('#tab_es a[href="#tabadd"]').tab('show');
        }
    })

    $(document).on('click', '.btn_eess_del', function () {
        const keyEess = $(this).data('keyeess');
        
        if(keyEess){
            $.ajax({
                url: `${base_url}esssalud/del`,
                type: "POST",
                data: {keyEess: keyEess},
                dataType: "JSON",
            })
            .done((data) => {
                const {status, msg} = data;
                if(status){
                    Toast.fire({
                        icon: 'success',
                        title: `${msg}`
                    })
                }else{
                    Toast.fire({
                        icon: 'danger',
                        title: `${msg}`
                    })
                }
                setTimeout(()=> {
                    window.location.reload();
                }, 2500)
            })
            .fail(function(jqXHR, statusText){
                fn_errorJqXHR(jqXHR, statusText);
            });
        }else{
            Toast.fire({
                icon: 'warning',
                title: 'Ocurrio un problema, recarga la página'
            })
        }
    });


  </script>

<?= $this->endSection() ?>