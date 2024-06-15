<?= $this->extend('layout/vlayout') ?>
<!--  -->
<?= $this->section('page_title') ?> Seguimiento de sospechosos | <?= SYS_TITLE; ?> <?= $this->endSection() ?>

<?= $this->section('contenido') ?>

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><i class="fas fa-sliders-h"></i> Seguimiento de sospechosos</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('home')?>">Inicio</a></li>
              <li class="breadcrumb-item active">Seguimiento de sospechosos</li>
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
                            <!-- <ul id="tab_es" class="nav nav-pills ml-auto p-2">
                                <li class="nav-item"><a class="nav-link active" href="#tabes" data-toggle="tab">Lista</a></li>
                                <li class="nav-item"><a class="nav-link" href="#tabadd" data-toggle="tab">Agregar</a></li>
                            </ul> -->
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tabes">
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                            <div class="row">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="sle_ssoview_region">Region</label>
                                                        <select id="sle_ssoview_region" class="form-control" data-send="view">
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
                                            </div>

                                            <div class="row">
                                                <div class="col-xl-12 col-lg-12 col-md-3 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="sle_ssoview_depa">Departamento</label>
                                                        <select id="sle_ssoview_depa" class="form-control" data-send="view">
                                                            <option value="">Selecciona un departamento</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="sle_ssoview_prov">Provincia</label>
                                                        <select id="sle_ssoview_prov" class="form-control" data-send="view">
                                                            <option value="">Selecciona una provincia</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="sle_ssoview_distr">Distrito</label>
                                                        <select id="sle_ssoview_distr" class="form-control" data-send="view">
                                                            <option value="">Selecciona una distrito</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="sle_ssoview_locali">Localidad</label>
                                                        <select id="sle_ssoview_locali" class="form-control" data-send="view">
                                                            <option value="">Selecciona una localidad</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <button type="button" id="btn_buscar" class="btn btn-primary">Buscar</button>
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div id="div_response_sos"></div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                            <div id="map"></div>
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

  <script type='text/javascript'>
    $(() => {
        fn_cargarSospechososReferencias();
    })

    var map = L.map('map').setView([-5.3745, -80.72755], 11); 

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
    
    $div_response_sos = $('#div_response_sos');

    let heatLayers = [];
    const fn_cargarSospechososReferencias = () => {
        $div_response_sos.html('');

        heatLayers.forEach(layer => map.removeLayer(layer));
        heatLayers = [];

        const optionshHeadMap = {
            radius: 20,
            blur: 15, 
            maxZoom: 11,
            gradient: {
                0.4: 'blue',
                0.6: 'cyan',
                0.7: 'lime',
                0.8: 'yellow',
                1.0: 'red'
            }
        }
        
        $.ajax({
            url: `${base_url}seguimiento/sospechosos`,
            type: "POST",
            dataType: "JSON",
            data : {codLoc : codLoc}
        })
        .done((data) => {
            const { status, msg, dataSospechosoRef, mapLoc } = data;

            if(mapLoc && Array.isArray(mapLoc) && mapLoc.length === 2){
                map.panTo(mapLoc);
                map.setView(mapLoc, 11);
            }

            if(status){

              dataSospechosoRef.forEach((childrem, i) => {
                let heatLayer = `heatLayer${i}`;
                let heatData = `heatData${i}`;
                heatData = [];
                childrem.forEach((el, i) => {
                    let { key_sos, eje_x, eje_y } = el;
                    let coordenadas = [ eje_x, eje_y ];
                    heatData.push(coordenadas);
                })
                heatLayer = L.heatLayer(heatData, optionshHeadMap).addTo(map);
                heatLayers.push(heatLayer);
              });
            }else{
                $div_response_sos.html(`<div class="alert alert-warning" role="alert"><i class="fas fa-ban"></i> ${msg}</div>`);
            }
        })
        .fail((jqXHR, statusText) => {
            fn_errorJqXHR(jqXHR, statusText);
        });
    }

    $sle_ssoview_region = $('#sle_ssoview_region');
    $sle_ssoview_depa   = $('#sle_ssoview_depa');
    $sle_ssoview_prov   = $('#sle_ssoview_prov');
    $sle_ssoview_distr  = $('#sle_ssoview_distr');
    $sle_ssoview_locali = $('#sle_ssoview_locali');

    $sle_ssoview_region.change(function (e) {
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
                    $sle_ssoview_depa.html(`${dataDepartamentos}`);
                }
            })
            .fail((jqXHR, statusText) => {
                fn_errorJqXHR(jqXHR, statusText);
            });
        }
    });

    $sle_ssoview_depa.change(function (e) {
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
                    $sle_ssoview_prov.html(`${dataProvincias}`);
                }
            })
            .fail((jqXHR, statusText) => {
                fn_errorJqXHR(jqXHR, statusText);
            });
        }
    });

    $sle_ssoview_prov.change(function (e) {
        e.preventDefault();

        codProv = $(this).val();

        if(codDep){
            $.ajax({
                url: `${base_url}distritos`,
                type: "POST",
                data: {codProv: codProv},
                dataType: "JSON"
            })
            .done((data) => {
                const { status, dataDistritos } = data;
                if(status){
                    $sle_ssoview_distr.html(`${dataDistritos}`);
                }
            })
            .fail((jqXHR, statusText) => {
                fn_errorJqXHR(jqXHR, statusText);
            });
        }
    });

    $sle_ssoview_distr.change(function (e) {
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
                    $sle_ssoview_locali.html(`${dataLocalidad}`);
                }
            })
            .fail((jqXHR, statusText) => {
                fn_errorJqXHR(jqXHR, statusText);
            });
        }
    });

    let codLoc;
    $sle_ssoview_locali.change(function (e) {
        codLoc = $(this).val();
    })

    $('#btn_buscar').click(function(){
        fn_cargarSospechososReferencias();
    })

  </script>

<?= $this->endSection() ?>