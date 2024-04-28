<?= $this->extend('layout/vlayout') ?>
<!--  -->
<?= $this->section('page_title') ?> Usuarios | <?= SYS_TITLE; ?> <?= $this->endSection() ?>

<?= $this->section('contenido') ?>

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><i class="fas fa-sliders-h"></i> Usuarios</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('home')?>">Inicio</a></li>
              <li class="breadcrumb-item active">Usuarios</li>
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
                            <ul id="tab_usu" class="nav nav-pills ml-auto p-2">
                                <li class="nav-item"><a class="nav-link active" href="#tabusu" data-toggle="tab">Lista</a></li>
                                <li class="nav-item"><a class="nav-link" href="#tabup" data-toggle="tab">Config</a></li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tabusu">
                                    <div class="row justify-content-center">
                                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                            <input type="search" id="txt_viewusua_apeno" name="txt_viewusua_apeno" class="form-control" placeholder="Ingresar apellidos y nombres">
                                        </div>
                                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12">  
                                            <button type="button" id="btn_buscar_usuarios" class="btn btn-primary btn-block"> Buscar</button> 
                                        </div>
                                    </div>
                                    <hr class="my-4">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <table id="tbl_usuarios" class="table table-striped table-bordered table-sm table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Persona</th>
                                                        <th>Usuario</th>
                                                        <th>Nivel</th>
                                                        <th>Acc.</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tabup">
                                    <div class="card card-primary">
                                        <form id="frm_user" action="<?= base_url(); ?>usuario/update" method="POST">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                                        <h4 id="lbl_viewusu_name"></h4>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <input type="hidden" name="txt_crudusu_keyusu" id="txt_crudusu_keyusu">
                                                    
                                                    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label for="txt_crudusu_constraseña">Constraseña</label>
                                                            <input type="text" class="form-control" id="txt_crudusu_constraseña" name="txt_crudusu_constraseña" placeholder="Constraseña">
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label for="sle_usucrud_nivel">Nivel</label>
                                                            <select id="sle_usucrud_nivel" name="sle_usucrud_nivel" class="form-control">
                                                                <option value="#">Selecciona una región</option>
                                                                <option value="MQ--">Administrador</option>
                                                                <option value="Mg--">Supervisor</option>
                                                                <option value="Mw--">Brigada</option>
                                                            </select>
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
        fn_getDataUsuarios();
    })

    const div_overlay_act = 'div_overlay_act';

    function fn_getDataUsuarios(){
        const perso = $('#txt_viewusua_apeno').val();

        const objData = { perso : perso };
        $.ajax({
            url: `${base_url}usuarios/list`,
            type: "POST",
            data: objData,
            dataType: "JSON",
        })
        .done(function(data){
            const { status, dataUsuarios } = data;
            if(status){
                $('#tbl_usuarios tbody').html(`${dataUsuarios}`);
            }
        })
        .fail(function(jqXHR, statusText){
            fn_errorJqXHR(jqXHR, statusText);
        });
    }

    $('#btn_buscar_usuarios').click(function(){
        fn_getDataUsuarios();
    })

    $('#frm_user').submit(function (e) {
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

    const tabusu = '#tab_usu a[href="#tabup"]';

    $(`${tabusu}`).click(function() {
        $(this).addClass('disabled');
    })

    $(document).on('click', '.btn_usu_update', function() { 
        $(`${tabusu}`).removeClass('disabled');

        const keyUsu = $(this).data('keyusu'),
        usu = $(this).data('usu'),
        keyNiv = $(this).data('keynivel');

        if(keyUsu && usu && keyNiv){
            $('#lbl_viewusu_name').html(`<i class="fas fa-user"></i> Usuario: ${usu}`)
            $('#txt_crudusu_keyusu').val(keyUsu);
            $('#txt_crudusu_constraseña').val('');
            $('#sle_usucrud_nivel').val(keyNiv);
        }
        $(`${tabusu}`).tab('show');
    })

  </script>

<?= $this->endSection() ?>