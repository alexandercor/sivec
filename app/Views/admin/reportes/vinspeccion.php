<?= $this->extend('layout/vlayout') ?>
<!--  -->
<?= $this->section('page_title') ?> Reportes - Inspección | <?= SYS_TITLE; ?> 
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><i class="fas fa-sliders-h"></i> Reportes - Inspección para la Vigilancia y Control</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('home')?>">Inicio</a></li>
              <li class="breadcrumb-item active">Reportes - Inspección</li>
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
                            <ul id="tab_loc" class="nav nav-pills ml-auto p-2">
                                <li class="nav-item"><a class="nav-link active" href="#tabloc" data-toggle="tab"><i class="fas fa-user-tie"></i> Inspector</a></li>
                                <!-- <li class="nav-item"><a class="nav-link" href="#tabadd" data-toggle="tab">Agregar</a></li> -->
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tabloc">
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="sle_insview_supervisor"><i class="fas fa-user-tie"></i> Inspector</label>
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
                                                <label for="sle_insview_supervisor"><i class="fas fa-user-tie"></i>.</label>
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
                                                        <th>Supervisor</th> 
                                                        <th>Actividad</th>
                                                        <th>EESS</th>
                                                        <th>Sector</th>
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
    </section>
<?= $this->endSection() ?>

<?= $this->section('javascript') ?>

    <script type="text/javascript">
        $(() => {
            fn_getDataInspecciones();
        })

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
            })
            .done(function(data){
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

    </script>

<?= $this->endSection() ?>