<?= $this->extend('layout/vlayout') ?>
<!--  -->
<?= $this->section('page_title') ?> Seguimiento de supervisores| <?= SYS_TITLE; ?> <?= $this->endSection() ?>

<?= $this->section('contenido') ?>

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><i class="fas fa-sliders-h"></i> Seguimiento de supervisores</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('home')?>">Inicio</a></li>
              <li class="breadcrumb-item active">Seguimiento de supervisores</li>
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
        fn_cargarCoordenadas();
    })
    
    setTimeout(() => {
        // window.location.reload();
        fn_cargarCoordenadas();
    }, 50000);

    // const puntos = [
    //     [51.5, -0.09],
    //     [51.51, -0.1],
    //     [51.49, -0.1]
    // ];

    const map = L.map('map')
    .setView([-5.2008333333333, -80.625277777778],
    12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
    
    const fn_cargarCoordenadas = () => {
        $.ajax({
            url: `${base_url}/seguimiento/coordenadaslist`,
            type: "POST",
            dataType: "JSON",
        })
        .done((data) => {
            const { status, dataCoordenadas } = data;
            if(status){
                for (let i = 0; i < dataCoordenadas.length; i++) {
                    const element = dataCoordenadas[i];
                    const { ejex, ejey, supervisor } = element;
                    const ubicacion = [ ejex, ejey ];
                    const marker = L.marker(ubicacion).addTo(map);
                    marker.bindPopup(`<b>${supervisor}</b>`);
                }
            }
        })
        .fail((jqXHR, statusText) => {
            fn_errorJqXHR(jqXHR, statusText);
        });
    }

    // for (let i = 0; i < puntos.length; i++) {
    //     const element = puntos[i];
    //     L.marker(element).addTo(map);
    // }
    // const marker = L.marker([51.5, -0.09]).addTo(map);

    // const circle = L.circle([51.505, -0.09], {
    //     color: 'red',
    //     fillColor: '#f03',
    //     fillOpacity: 0.5,
    //     radius: 500
    // }).addTo(map);

  </script>

<?= $this->endSection() ?>