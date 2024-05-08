<?= $this->extend('layout/vlayout') ?>
<!--  -->
<?= $this->section('page_title') ?> Localidad | <?= SYS_TITLE; ?> <?= $this->endSection() ?>

<?= $this->section('contenido') ?>

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><i class="fas fa-sliders-h"></i> Localidad</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('home')?>">Inicio</a></li>
              <li class="breadcrumb-item active">Localidad</li>
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
                                                <button type="button" id="btn_buscar_loc" class="btn btn-primary btn-block">Buscar</button>
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

<?= $this->section('javascript') ?>

  <script type='text/javascript'>
    $(() => {
        fn_getDataLocalidad();
    })

    const div_overlay_es = 'div_overlay_es';
    let codReg, codDep, codProv, codDis, codLoc, codSec;

    const objSelectsData = {
        view : {
            sleDis : '#sle_locview_distr',
            slePro : '#sle_locview_prov',
            sleDep : '#sle_locview_depa',
            sleReg : '#sle_locview_region'
        },
        crud : {
            sleDis : '#sle_loccrud_distr',
            slePro : '#sle_loccrud_prov',
            sleDep : '#sle_loccrud_depa',
            sleReg : '#sle_loccrud_region'
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
            fn_limpiar_select(3, typeSend);

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
        fn_limpiar_select(2, typeSend);

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
            fn_limpiar_select(1, typeSend);

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

        codDis = $(this).val();
    });

    function fn_getDataLocalidad(){

        const loca = $('#txt_locview_loc').val();
        const objData = { codDis : codDis, localidad: loca };
        $.ajax({
            url: `${base_url}localidad/list`,
            type: "POST",
            data: objData,
            dataType: "JSON",
        })
        .done(function(data){
            const { status, dataLocalidad } = data;
            if(status){
                $('#tbl_loc tbody').html(`${dataLocalidad}`);
            }
        })
        .fail(function(jqXHR, statusText){
            fn_errorJqXHR(jqXHR, statusText);
        });
    }

    $('#btn_buscar_loc').click(function(){
        fn_getDataLocalidad();
    })

    $('#frm_loc').submit(function (e) {
        e.preventDefault();

        $('#div_errors').html('');

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

    $('#tab_loc a[href="#tabloc"]').click(function(){
        $('#tab_loc a[href="#tabadd"]').text('Agregar');
        $('#frm_loc')[0].reset();
    })

    $(document).on('click', '.btn_loca_edit', function() {

        $('#tab_loc a[href="#tabadd"]').text('Editar')

        const keyEst = $(this).data('keyest'),
            keyLoca = $(this).data('keyloc'),
            loc    = $(this).data('loc'),
            keyDis  = $(this).data('keydis');

        if(keyEst === 'Mg--' && keyLoca && loc && keyDis){
            
            $('#txt_loccrud_esta').val(keyEst);
            $('#txt_loccrud_keyloca').val(keyLoca);
            $('#txt_loccrud_loc').val(loc);
            $('#tab_loc a[href="#tabadd"]').tab('show');
        }
    })

    $(document).on('click', '.btn_loca_del', function () {
        const keyLoc = $(this).data('keyloc');
        
        if(keyLoc){
            $.ajax({
                url: `${base_url}localidad/del`,
                type: "POST",
                data: {keyLoc: keyLoc},
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