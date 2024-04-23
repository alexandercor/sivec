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
                                            <label for="exampleInputEmail1">Denominación</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Denominación">
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
        <div class="container-fluid" id="div_overlay_act">
            <div class="card card-navy card-outline">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-xs-12">
                            <input type="search" id="txt_viewact_actividad" name="txt_viewact_actividad" class="form-control" placeholder="Ingresar una actividad">
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12">  
                            <button type="button" id="btn_buscar_actividad" class="btn btn-primary btn-block rounded-pill"><i class="fas fa-search"></i> Buscar</button> 
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12">  
                            <button type="button" class="btn btn-success btn-block rounded-pill" data-toggle="modal" data-target="#mdl_actividad"><i class="fas fa-plus"></i> Agregar</button> 
                        </div>
                    </div>
                    <hr class="my-4">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
            </div>
        </div>
    </section>
    
    <section class="modal fade" id="mdl_actividad" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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