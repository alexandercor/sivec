<?= $this->extend('layout/vlayout') ?>
<!--  -->
<?= $this->section('page_title') ?> Formato 03 : Inspección de viviendas para la vigilancia y control del Aedes Aegypti | <?= SYS_TITLE; ?> 
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><i class="fas fa-sliders-h"></i> Formato 03 : Inspección de viviendas para la vigilancia y control del Aedes Aegypti</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('home')?>">Inicio</a></li>
              <li class="breadcrumb-item active">Formato 03 : Inspección de viviendas para la vigilancia y control del Aedes Aegypti</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
        <div class="container-fluid" id="div_overlay">
            <div class="row">
                <div class="col-12">
                    <div class="card card-navy card-outline">
                        <div class="card-header p-0">
                            <!-- <ul id="tab_loc" class="nav nav-pills ml-auto p-2">
                                <li class="nav-item"><a class="nav-link active" href="#tabloc" data-toggle="tab"><i class="fas fa-user-tie"></i> Inspector</a></li>
                            </ul> -->
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tabloc">
                                    <div class="row">
                                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <select id="sle_insview_supervisor" class="form-control form-control-lg" data-send="view">
                                                    <option value="">Selecciona un Inspector</option>
                                                    <?php
                                                        foreach($inspectores as $ins){
                                                            $keyIns = bs64url_enc($ins->key_per);
                                                            $inspec = $ins->inspector;
                                                            echo "<option value='$keyIns'>$inspec</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <button type="button" id="btn_inspecciones_buscar" class="btn btn-primary btn-lg"><i class="fas fa-search"></i> Buscar</button>
                                            </div>                    
                                        </div>
                                    </div>
                                    <hr class="mt-0">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
                                            <table id="tbl_inspec" class="table table-striped table-bordered table-sm table-hover projects">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Fecha Control</th>
                                                        <th>Inspector</th> 
                                                        <th>Actividad</th>
                                                        <th>EESS</th>
                                                        <th>Sector</th>
                                                        <th>Imágenes</th>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

        <div class="modal fade" id="mdl_control_imgg">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="far fa-images"></i> Imagenes de Control e Inspección</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div id="mdl_content_images"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-times-circle"></i> Close</button>
                    </div>
                </div>
            <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

    </section>


<?= $this->endSection() ?>

<?= $this->section('javascript') ?>

    <script type="text/javascript">
        $(() => {
            fn_getDataInspecciones();
        })

        $mdl_control_imgg =$('#mdl_control_imgg');
        $mdl_content_img  = $('#mdl_content_img');

        let codIns;
        $('#sle_insview_supervisor').change( function(){
            codIns = $(this).val();
        })

        function fn_getDataInspecciones(){
            $('#tbl_inspec tbody').html('');

            $.ajax({
                url: `${base_url}inspecciones/list`,
                type: "POST",
                data: {codIns: codIns},
                dataType: "JSON",
                beforeSend: function(){
                    $('#div_overlay').loading({message: 'Cargando...'});
                },
            })
            .done(function(data){
                $('#div_overlay').loading('stop');
                const { status, dataInspecciones } = data;
                if(status){
                    $('#tbl_inspec tbody').html(`${dataInspecciones}`);
                }
            })
            .fail(function(jqXHR, statusText){
                fn_errorJqXHR(jqXHR, statusText);
            });
        }

        $('#btn_inspecciones_buscar').click(function(){
            fn_getDataInspecciones();
        })

        $mdl_control_imgg.on('show.bs.modal', function(e){
            let target = $(e.relatedTarget);
            const keyControl = target.data('keycontrol');

            $.ajax({
                url: `${base_url}control/getimg`,
                type: "POST",
                data: {keyControl: keyControl},
                dataType: "JSON",
                success: function (data) {
                    const { status, dataImgs } = data;
                    if(status){
                        $('#mdl_control_imgg .modal-body #mdl_content_images').html(dataImgs);
                    }
                }
            });
        })
        .on("hidden.bs.modal",function(){
            $('#mdl_control_imgg .modal-body #mdl_content_images').html('');
        });

    </script>

<?= $this->endSection() ?>