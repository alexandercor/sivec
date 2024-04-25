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
        <div class="container-fluid" id="div_overlay_act">
            <div class="card card-navy card-outline">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-xs-12">
                            <input type="search" id="txt_viewrec_recipi" name="txt_viewrec_recipi" class="form-control" placeholder="Ingresar un recipiente">
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12">  
                            <button type="button" id="btn_buscar_rec" class="btn btn-primary btn-block"> Buscar</button> 
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12">  
                            <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#mdl_recip"> Agregar</button> 
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
            </div>
        </div>
    </section>
    
    <section class="modal fade" id="mdl_recip" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="frm_reci" action="<?= base_url(); ?>recipiente/add" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Recipiente</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <input type="text" name="txt_mdlcrudrec_est" id="txt_mdlcrudrec_est" value="MQ--">
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
        }
    });

    $('#mdl_recip')
    .on('show.bs.modal', function(e){
        const target = (e.relatedTarget);
        console.log('primera carga')
        // const keyRec = target.data('');

        $('#txt_mdlcrudrec_est').val('Mg--')
    })
  </script>

<?= $this->endSection() ?>