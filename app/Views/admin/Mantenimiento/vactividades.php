<?= $this->extend('layout/vlayout') ?>
<!--  -->
<?= $this->section('page_title') ?> Actividades | <?= SYS_TITLE; ?> <?= $this->endSection() ?>

<?= $this->section('contenido') ?>

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><i class="fas fa-sliders-h"></i> Actividades</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('home')?>">Inicio</a></li>
              <li class="breadcrumb-item active">Actividades</li>
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
                            <ul id="tab_act" class="nav nav-pills ml-auto p-2">
                                <li class="nav-item"><a class="nav-link active" href="#tabac" data-toggle="tab">Lista</a></li>
                                <li class="nav-item"><a class="nav-link" href="#tabadd" data-toggle="tab">Agregar</a></li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tabac">
                                    <div class="row justify-content-center">
                                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                            <input type="search" id="txt_viewact_actividad" name="txt_viewact_actividad" class="form-control" placeholder="Ingresar una actividad">
                                        </div>
                                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12">  
                                            <button type="button" id="btn_buscar_actividad" class="btn btn-primary btn-block"> Buscar</button> 
                                        </div>
                                    </div>
                                    <hr class="my-4">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
                                            <table id="tbl_actividades" class="table table-striped table-bordered table-sm table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Actividad</th>
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
                                        <form id="frm_actidividad" action="<?= base_url(); ?>actividades/add" method="POST">
                                            <div class="card-body">
                                                <div class="row">
                                                    <input type="hidden" name="txt_crudact_esta" id="txt_crudact_esta" value="MQ--">
                                                    <input type="hidden" name="txt_crudact_keyact" id="txt_crudact_keyact">

                                                    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label for="txt_mdlviewact_activ">Denominación</label>
                                                            <input type="text" class="form-control" id="txt_crudact_activ" name="txt_crudact_activ" placeholder="Denominación">
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
        fn_getDataActividad();
    })

    const div_overlay_act = 'div_overlay_act';

    let actividad;
    $('#txt_viewact_actividad').on('input', function () {
        actividad = $(this).val();
    });

    function fn_getDataActividad(){
        const acti = $('#txt_viewact_actividad').val();

        const objData = { actividad : acti };
        $.ajax({
            url: `${base_url}actividadeslist`,
            type: "POST",
            data: objData,
            dataType: "JSON",
        })
        .done(function(data){
            const { status, dataActividad } = data;
            if(status){
                $('#tbl_actividades tbody').html(`${dataActividad}`);
            }
        })
        .fail(function(jqXHR, statusText){
            fn_errorJqXHR(jqXHR, statusText);
        });
    }

    $('#btn_buscar_actividad').click(function(){
        fn_getDataActividad();
    })

    $('#frm_actidividad').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
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
            }else{
                $('#div_response').html(`<h4 class="text-danger"><i class="fas fa-check-circle"></i> ${msg} </h4>`);
            }
        })
        .fail(function(jqXHR, statusText){
            fn_errorJqXHR(jqXHR, statusText);
        });
        return false;
    });

    $('#tab_act a[href="#tabadd"]').click(function() {
        $('#txt_crudact_activ').val('');
        $('#txt_crudact_esta').val('MQ--');
    })

    $('#tab_rec a[href="#tabac"]').click(function(){
        $('#tab_rec a[href="#tabadd"]').text('Agregar');
    })

    $(document).on('click', '.btn_act_edit', function() {

        $('#tab_act a[href="#tabadd"]').text('Editar')

        const keyEst = $(this).data('keyest'),
        keyAct = $(this).data('keyact'),
        activ = $(this).data('act');
        if(keyEst === 'Mg--' && keyAct && activ){
            $('#txt_crudact_esta').val(keyEst);
            $('#txt_crudact_keyact').val(keyAct);
            $('#txt_crudact_activ').val(activ);
            $('#tab_act a[href="#tabadd"]').tab('show');
        }
    })

    $(document).on('click', '.btn_act_del', function () {
        const keyAct = $(this).data('keyact');
        
        if(keyAct){
            $.ajax({
                url: `${base_url}actividades/del`,
                type: "POST",
                data: {keyAct: keyAct},
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