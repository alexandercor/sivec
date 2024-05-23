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
                            <ul id="tab_es" class="nav nav-pills ml-auto p-2">
                                <!-- <li class="nav-item"><a class="nav-link active" href="#tabes" data-toggle="tab">Lista</a></li> -->
                                <!-- <li class="nav-item"><a class="nav-link" href="#tabadd" data-toggle="tab">Agregar</a></li> -->
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tabes">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
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

    var map = L.map('map').setView([-5.3745, -80.72755], 13); 

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    const fn_cargarSospechososReferencias = () => {
        $.ajax({
            url: `${base_url}/seguimiento/sospechosos`,
            type: "POST",
            dataType: "JSON",
        })
        .done((data) => {
            const { status, dataSospechosoRef } = data;
            if(status){
                console.log(dataSospechosoRef)
            }
        })
        .fail((jqXHR, statusText) => {
            fn_errorJqXHR(jqXHR, statusText);
        });
    }

    var heatData = [
      [-5.3745, -80.72755, 0.5],
      [-5.37409409103852, -80.72698137654706, 0.5],
      [-5.373634778783446, -80.72730324161623, 0.5],
      [-5.375717703675289, -80.72704574956087, 0.5]
    ];

    var heat = L.heatLayer(heatData, {
      radius: 20, // Radio del punto de calor
      blur: 19, // Desenfoque del punto de calor
      maxZoom: 11, // Zoom máximo en el que el calor se mostrará
      gradient: {
        0.4: 'blue',
        0.6: 'cyan',
        0.7: 'lime',
        0.8: 'yellow',
        1.0: 'red'
      } // Gradiente personalizado de azul a rojo
    }).addTo(map);

    var heatData2 = [
      [-5.3748204445953345, -80.72364470866336, 0.2],
      [-5.373389099993218, -80.723269199416, 0.2],
      [-5.374809762931653, -80.72404167558199, 0.2],
      [-5.376679051222254, -80.72542569537941, 0.2]
    ];

   
    var heatLayer2 = L.heatLayer(heatData2, {
      radius: 25, 
      blur: 20,   
      maxZoom: 11,
      gradient: {
        0.4: 'blue',
        0.6: 'cyan',
        0.7: 'lime',
        0.8: 'yellow',
        1.0: 'red'
      }
    }).addTo(map);

  </script>

<?= $this->endSection() ?>