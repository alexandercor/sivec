<?= $this->extend('layout/vlayout') ?>
<!--  -->
<?= $this->section('page_title') ?> Colaborador | <?= SYS_TITLE; ?> <?= $this->endSection() ?>

<?= $this->section('contenido') ?>

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><i class="fas fa-sliders-h"></i> Colaborador</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('home')?>">Inicio</a></li>
              <li class="breadcrumb-item active">Colaborador</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-navy">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-user-circle"></i> Datos</h3>
                        </div>
                        <form>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Apellidos y Nombres</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Apellidos y Nombres">
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Fecha de Nacimiento</label>
                                            <input type="date" class="form-control" id="exampleInputEmail1">
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Email</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Email">
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Celular 1</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Celular 1">
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Celular 2</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Celular 2">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section> -->

    <section class="content">
        <div class="container-fluid" id="div_overlay">
            <div class="row">
                <div class="col-12">
                    <div class="card card-navy card-outline">
                        <div class="card-header p-0">
                            <ul id="tab_persona" class="nav nav-pills ml-auto p-2">
                                <li class="nav-item"><a class="nav-link active" href="#tabper" data-toggle="tab">Lista</a></li>
                                <li class="nav-item"><a class="nav-link" href="#tabadd" data-toggle="tab">Agregar</a></li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tabper">
                                    <div class="row justify-content-center">
                                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                            <input type="search" id="txt_viewper_persona" name="txt_viewper_persona" class="form-control" placeholder="Ingresar una persona">
                                        </div>
                                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12">  
                                            <button type="button" id="btn_buscar_persona" class="btn btn-primary btn-block"> Buscar</button> 
                                        </div>
                                    </div>
                                    <hr class="my-4">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
                                            <table id="tbl_persona" class="table table-striped table-bordered table-sm table-hover projects">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Fech_Reg</th>
                                                        <th>Dni</th>
                                                        <th>Persona</th>
                                                        <th>Fech_Nac</th>
                                                        <th>Email</th>
                                                        <th>Celular</th>
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
                                        <form id="frm_persona" action="<?= base_url(); ?>persona/add" method="POST">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div id="div_errors" class="error_danger"></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <input type="hidden" name="txt_crudper_esta" id="txt_crudper_esta" value="MQ--">
                                                    <input type="hidden" name="txt_crudper_keyper" id="txt_crudper_keyper">

                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label for=id="txt_crudper_dni" >Dni</label>
                                                            <input type="number" class="form-control" id="txt_crudper_dni" name="txt_crudper_dni"
                                                            placeholder="Dni">
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label for="txt_crudper_per" >Apellidos y Nombres</label>
                                                            <input type="text" class="form-control text-uppercase" id="txt_crudper_per" name="txt_crudper_per"   placeholder="Apellidos y Nombres">
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label for="txt_crudper_fechnac" >Fecha de Nacimiento</label>
                                                            <input type="date" class="form-control" id="txt_crudper_fechnac" name="txt_crudper_fechnac">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label for="txt_crudper_email">Email</label>
                                                            <input type="text" class="form-control" id="txt_crudper_email" name="txt_crudper_email" placeholder="Email">
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label for="txt_crudper_celular">Celular 1</label>
                                                            <input type="number" class="form-control" id="txt_crudper_celular" name="txt_crudper_celular" placeholder="Celular 1">
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label for="txt_crudper_celular2">Celular 2</label>
                                                            <input type="number" class="form-control" id="txt_crudper_celular2" name="txt_crudper_celular2" placeholder="Celular 2">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="div_section_user">
                                                <hr>
                                                <div class="row">
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label for="txt_crudper_usuario">Usuario</label>
                                                            <input type="text" class="form-control" id="txt_crudper_usuario" name="txt_crudper_usuario" placeholder="Usuario">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label for="txt_crudper_contraseña">Constraseña</label>
                                                            <input type="text" class="form-control" id="txt_crudper_contraseña" name="txt_crudper_contraseña" placeholder="Contraseña">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label for="sle_percrud_nivel">Nivel de Usuario del sistema</label>
                                                            <select id="sle_percrud_nivel" name="sle_percrud_nivel" class="form-control">
                                                                <option value="">Selecciona un nivel de usuario</option>
                                                                <option value="MQ--">Administrador</option>
                                                                <option value="Mg--">Inspector</option>
                                                                <option value="Mw--">Jefe de Brigada</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label for="sle_percrud_tip_col">Tipo de Colaborador</label>
                                                            <select id="sle_percrud_tip_col" name="sle_percrud_tip_col" class="form-control">
                                                                <option value="">Selecciona un tipo de colaborador</option>
                                                                <option value="MQ--">Administrador</option>
                                                                <option value="Mg--">Inspector</option>
                                                                <option value="Mw--">Jefe de Brigada</option>
                                                            </select>
                                                        </div>
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

  <script type='text/javascript' >
    
    $(() => {
        fn_getDataPersonas();
    })


    $(document).on('input', '#txt_crudper_dni', function(e){
        const valor = $(this).val();
        if(valor.length > 8){
            $('#div_response').html(`<h4 class="text-danger"> El valor ingresado debe tener exactamente 8 caracteres </h4>`);
            $(this).attr('readonly', true);
        }else{
            $('#div_response').html('');
        }
    })

    $(document).on('input', '#txt_crudper_celular, #txt_crudper_celular2', function(e){
        const valor = $(this).val();
        if(valor.length > 9){
            $('#div_response').html(`<h4 class="text-danger"> El valor ingresado debe tener exactamente 9 caracteres </h4>`);
            $(this).attr('readonly', true);
        }else{
            $('#div_response').html('');
        }
    })

    const div_overlay_act = 'div_overlay_act';

    let persona;
    $('#txt_viewper_persona').on('input', function () {
        persona = $(this).val();
    });

    function fn_getDataPersonas(){
        const persona = $('#txt_viewper_persona').val();

        const objData = { persona : persona };
        $.ajax({
            url: `${base_url}persona/list`,
            type: "POST",
            data: objData,
            dataType: "JSON",
        })
        .done(function(data){
            const { status, dataPersonas } = data;
            if(status){
                $('#tbl_persona tbody').html(`${dataPersonas}`);
            }
        })
        .fail(function(jqXHR, statusText){
            fn_errorJqXHR(jqXHR, statusText);
        });
    }

    $('#btn_buscar_persona').click(function(){
        fn_getDataPersonas();
    })

    $('#txt_viewper_persona').keypress(function(e){
        const keyEvent = e.keyCode || e.which;
        if(keyEvent === 13){
            fn_getDataPersonas();
        }
    })

    $('#frm_persona').submit(function (e) {
        e.preventDefault();

        $('#div_errors').empty();
        $('#div_response').empty();
        
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: $(this).serialize(),
            dataType: "JSON",
            beforeSend: function(){
                $('#div_overlay').loading({message: 'Cargando...'});
            },
        })
        .done(function(data){
            $('#div_overlay').loading('stop');
            const { status, msg, errors } = data;
            if(status){
                $('#div_response').html(`<h4><i class="fas fa-check-circle"></i> ${msg} </h4>`);
                setTimeout(() => {
                    $('#mdl_actividad').modal('hide');   
                    window.location.reload();
                }, 4000);
            }else{
                if(msg){
                    $('#div_response').html(`<h4 class="text-danger"> ${msg} </h4>`);
                }

                if(Object.keys(errors).length !== 0){
                    let items = '';
                    for(const key in errors){
                        items += `<p>${errors[key]}</p>`; 
                    }
                    $('#div_errors').html(`<div class="alert">${items}</div>`);
                }
            }
        })
        .fail(function(jqXHR, statusText){
            fn_errorJqXHR(jqXHR, statusText);
        });
        return false;
    });

    $('#tab_persona a[href="#tabadd"]').click(function(e){
        $('#frm_persona')[0].reset();
        $('#txt_crudper_esta').val('MQ--');
        $('#div_errors').empty();
        $('#div_response').empty();
        $('#div_section_user').show();
    })

    $('#tab_persona a[href="#tabper"]').click(function(){
        $('#tab_persona a[href="#tabadd"]').text('Agregar');
        $('#div_errors').empty();
        $('#div_response').empty();
    })

    $(document).on('click', '.btn_per_edit', function () {
        $('#frm_persona')[0].reset();

        $('#tab_persona a[href="#tabadd"]').text('Editar')

        const keyEst = $(this).data('keyest'),
        keyPer = $(this).data('keyper'),
        dni    = $(this).data('dni'),
        per    = $(this).data('per'),
        fechnac = $(this).data('fechnac'),
        email  = $(this).data('email'),
        cel    = $(this).data('celular'),
        cel2   = $(this).data('celular2');

        if(keyEst === 'Mg--' && keyPer && dni && per && fechnac && cel){

            // $('#div_section_user').hide();

            $('#txt_crudper_esta').val(keyEst);
            $('#txt_crudper_keyper').val(keyPer);
            $('#txt_crudper_dni').val(dni);
            $('#txt_crudper_per').val(per);
            $('#txt_crudper_fechnac').val(fechnac);
            $('#txt_crudper_email').val(email);
            $('#txt_crudper_celular').val(cel);
            $('#txt_crudper_celular2').val(cel2);

            $('#div_section_user').hide();
            $('#txt_crudper_usuario').val('_');
            $('#txt_crudper_contraseña').val('_');
            $('#sle_percrud_nivel').val('MQ--');
            $('#sle_percrud_tip_col').val('MQ--');
            
            $('#tab_persona a[href="#tabadd"]').tab('show');
        }
    });

    $(document).on('click', '.btn_per_del', function () {
        const keyPer = $(this).data('keyper');
        
        if(keyPer){
            $.ajax({
                url: `${base_url}persona/del`,
                type: "POST",
                data: {keyPer: keyPer},
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