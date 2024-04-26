<?= $this->extend('layout/vlayout') ?>
<!--  -->
<?= $this->section('page_title') ?> Recipientes | <?= SYS_TITLE; ?> <?= $this->endSection() ?>

<?= $this->section('contenido') ?>

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><i class="fas fa-sliders-h"></i> Recipientes</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('home')?>">Inicio</a></li>
              <li class="breadcrumb-item active">Recipientes</li>
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
                            <ul id="tab_rec" class="nav nav-pills ml-auto p-2">
                                <li class="nav-item"><a class="nav-link active" href="#tabre" data-toggle="tab">Lista</a></li>
                                <li class="nav-item"><a class="nav-link" href="#tabadd" data-toggle="tab">Agregar</a></li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tabre">
                                    <div class="row justify-content-center">
                                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                            <input type="search" id="txt_viewrec_recipi" name="txt_viewrec_recipi" class="form-control" placeholder="Ingresar un recipiente">
                                        </div>
                                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12">  
                                            <button type="button" id="btn_buscar_rec" class="btn btn-primary btn-block"> Buscar</button> 
                                        </div>
                                    </div>
                                    <hr class="my-4">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <table id="tbl_reci" class="table table-striped table-bordered table-sm table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Recipiente</th>
                                                        <th>Medida</th>
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
                                        <form id="frm_reci" action="<?= base_url(); ?>recipiente/add" method="POST">
                                            <div class="card-body">
                                                <div class="row">
                                                    <input type="hidden" name="txt_mdlcrudrec_est" id="txt_mdlcrudrec_est" value="MQ--">
                                                    <input type="hidden" name="txt_mdlcrudrec_keyrec" id="txt_mdlcrudrec_keyrec">
                                                    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label for="txt_mdlcrudrec_rec">Recipiente</label>
                                                            <input type="text" class="form-control" id="txt_mdlcrudrec_rec" name="txt_mdlcrudrec_rec" placeholder="Recipiente">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label for="sle_mdlcrudviewmed_medida">Medida</label>
                                                            <select id="sle_mdlcrudviewmed_medida" name="sle_mdlcrudviewmed_medida" class="form-control">
                                                                <option value="#">Selecciona una medida</option>
                                                                <?php 
                                                                    foreach($mediadReci as $med){
                                                                        $keyMed = bs64url_enc($med->key_medi);
                                                                        echo "<option value='$keyMed'>$med->medida</option>";
                                                                    }
                                                                ?>
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
      fn_getDataRecipiente();
    })
    
    const div_overlay_act = 'div_overlay_act';

    let rec;
    $('#txt_viewrec_recipi').on('input', function () {
        rec = $(this).val();
    });

    function fn_getDataRecipiente(){
        const rec = $('#txt_viewrec_recipi').val();

        const objData = { rec : rec };
        $.ajax({
            url: `${base_url}recipiente/list`,
            type: "POST",
            data: objData,
            dataType: "JSON",
        })
        .done(function(data){
            const { status, dataRecipiente } = data;
            if(status){
                $('#tbl_reci tbody').html(`${dataRecipiente}`);
            }
        })
        .fail(function(jqXHR, statusText){
            fn_errorJqXHR(jqXHR, statusText);
        });
    }

    $('#btn_buscar_rec').click(function(){
       fn_getDataRecipiente();
    })

    $('#frm_reci').submit(function (e) {
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
                    $('#mdl_recip').modal('hide');   
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

    $(document).on('click', '.btn_rec_dele', function () {
        const key = $(this).data('key');
        
        if(key){
            $.ajax({
                url: `${base_url}recipiente/del`,
                type: "POST",
                data: {key: key},
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
    
    $('#tab_rec a[href="#tabadd"]').click(function(){
        $('#txt_mdlcrudrec_est, #txt_mdlcrudrec_keyrec, #txt_mdlcrudrec_rec, #sle_mdlcrudviewmed_medida').val('');

        $('#txt_mdlcrudrec_est').val('MQ--');
    })

    $('#tab_rec a[href="#tabre"]').click(function(){
        $('#tab_rec a[href="#tabadd"]').text('Agregar');
    })

    $(document).on('click', '.btn_rec_edit', function () {

        $('#tab_rec a[href="#tabadd"]').text('Editar');
        $('#txt_mdlcrudrec_keyrec, #txt_mdlcrudrec_rec, #sle_mdlcrudviewmed_medida').val('');

        const codestado = $(this).data('codestado'),
        keyRec = $(this).data('keyrec'),
        reci   = $(this).data('reci'),
        keyCap = $(this).data('keycapa');

        if(codestado === 'Mg--'){
            $('#tab_rec a[href="#tabadd"]').tab('show');
            $('#txt_mdlcrudrec_est').val(codestado);
            $('#txt_mdlcrudrec_keyrec').val(keyRec);
            $('#txt_mdlcrudrec_rec').val(reci);
            $('#sle_mdlcrudviewmed_medida').val(keyCap);
        }
    })

  </script>

<?= $this->endSection() ?>