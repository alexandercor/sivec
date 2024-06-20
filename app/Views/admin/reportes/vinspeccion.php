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
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="sle_insview_region">Region</label>
                                                <select id="sle_insview_region" class="form-control" data-send="view">
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
                                                <label for="sle_insview_depa">Departamento</label>
                                                <select id="sle_insview_depa" class="form-control" data-send="view">
                                                    <option value="">Selecciona un departamento</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="sle_insview_prov">Provincia</label>
                                                <select id="sle_insview_prov" class="form-control" data-send="view">
                                                    <option value="">Selecciona una provincia</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="sle_insview_distr">Distrito</label>
                                                <select id="sle_insview_distr" class="form-control" data-send="view">
                                                    <option value="">Selecciona una distrito</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row d-flex align-items-end">
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="sle_insview_locali">Localidad</label>
                                                <select id="sle_insview_locali" class="form-control" data-send="view">
                                                    <option value="">Selecciona una localidad</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <!-- <div class="form-group">
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
                                            </div> -->
                                            <div class="form-group">
                                                <label for="txt_insview_insp">Inspector</label>
                                                <input type="search" id="txt_insview_insp" class="form-control" placeholder="Apellidos y nombres de Inspector">
                                            </div>            
                                        </div>
                                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="dte_insview_fech">Fecha</label>
                                                <input type="date" id="dte_insview_fech" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <button type="button" id="btn_inspecciones_buscar" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
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

        $sle_insview_region = $('#sle_insview_region');
        $sle_insview_depa   = $('#sle_insview_depa');
        $sle_insview_prov   = $('#sle_insview_prov');
        $sle_insview_distr  = $('#sle_insview_distr');
        $sle_insview_locali = $('#sle_insview_locali');
        $txt_insview_insp = $('#txt_insview_insp');
        $dte_insview_fech = $('#dte_insview_fech');

        $mdl_control_imgg =$('#mdl_control_imgg');
        $mdl_content_img  = $('#mdl_content_img');

        $sle_insview_region.change(function (e) {
            e.preventDefault();
            
            codReg = $(this).val();
            if(codReg){
                $.ajax({
                    url: `${base_url}departamentos`,
                    type: "POST",
                    data: {codReg: codReg},
                    dataType: "JSON",
                })
                .done((data) => {
                    const { status, dataDepartamentos } = data;
                    if(status){
                        $sle_insview_depa.html(`${dataDepartamentos}`);
                    }
                })
                .fail((jqXHR, statusText) => {
                    fn_errorJqXHR(jqXHR, statusText);
                });
            }
        });

        $sle_insview_depa.change(function (e) {
            e.preventDefault();
            codDep = $(this).val();

            if(codDep){
                $.ajax({
                    url: `${base_url}provincias`,
                    type: "POST",
                    data: {codDep: codDep},
                    dataType: "JSON",
                })
                .done((data) => {
                    const { status, dataProvincias } = data;
                    if(status){
                        $sle_insview_prov.html(`${dataProvincias}`);
                    }
                })
                .fail((jqXHR, statusText) => {
                    fn_errorJqXHR(jqXHR, statusText);
                });
            }
        });

        $sle_insview_prov.change(function (e) {
            e.preventDefault();
            
            codProv = $(this).val();

            if(codDep){
                $.ajax({
                    url: `${base_url}distritos`,
                    type: "POST",
                    data: {codProv: codProv},
                    dataType: "JSON",
                })
                .done((data) => {
                    const { status, dataDistritos } = data;
                    if(status){
                        $sle_insview_distr.html(`${dataDistritos}`);
                    }
                })
                .fail((jqXHR, statusText) => {
                    fn_errorJqXHR(jqXHR, statusText);
                });
            }
        });

        $sle_insview_distr.change(function (e) {
            e.preventDefault();

            codDis = $(this).val();

            if(codDep){
                $.ajax({
                    url: `${base_url}localidad`,
                    type: "POST",
                    data: {codDis: codDis},
                    dataType: "JSON",
                })
                .done((data) => {
                    const { status, dataLocalidad } = data;
                    if(status){
                        $sle_insview_locali.html(`${dataLocalidad}`);
                    }
                })
                .fail((jqXHR, statusText) => {
                    fn_errorJqXHR(jqXHR, statusText);
                });
            }
        });

        let codLoc;
        $sle_insview_locali.change(function (e) {
            e.preventDefault();
            codLoc = $(this).val();
        });

        let codIns;
        $('#sle_insview_supervisor').change( function(){
            codIns = $(this).val();
        })

        function fn_getDataInspecciones(){
            $('#tbl_inspec tbody').html('');
            const inspe = $txt_insview_insp.val(),
                  fechControl = $dte_insview_fech.val();

            $.ajax({
                url: `${base_url}inspecciones/list`,
                type: "POST",
                data: {codLoc: codLoc, fechControl: fechControl, inspe: inspe },
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