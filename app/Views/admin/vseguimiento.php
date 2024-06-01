<?= $this->extend('layout/vlayout') ?>
<!--  -->
<?= $this->section('page_title') ?> Seguimiento de Inspectores | <?= SYS_TITLE; ?> <?= $this->endSection() ?>

<?= $this->section('contenido') ?>

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><i class="fas fa-chalkboard-teacher"></i> Seguimiento de Inspectores</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('home')?>">Inicio</a></li>
              <li class="breadcrumb-item active"><i class="fas fa-chalkboard-teacher"></i> Seguimiento de Inspectores</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
        <div class="container-fluid" id="divover_inspectores">
            <div class="row">
                <div class="col-12">
                    <div class="card card-navy card-outline">
                        <!-- <div class="card-header p-0">
                            <ul id="tab_es" class="nav nav-pills ml-auto p-2">
                                <li class="nav-item"><a class="nav-link active" href="#tabes" data-toggle="tab">Lista</a></li> 
                                <li class="nav-item"><a class="nav-link" href="#tabadd" data-toggle="tab">Agregar</a></li>
                            </ul>
                        </div> -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tabes">
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <div class="card card-primary">
                                                <div class="card-header">
                                                    <h3 class="card-title"><i class="fas fa-chalkboard-teacher"></i> Leyenda de Inspectores</h3>
                                                </div>
                                                <div class="card-body">
                                                    <div id="div_inspectores_legen"></div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-12">
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
    }, 180000);

    // const puntos = [
    //     [51.5, -0.09],
    //     [51.51, -0.1],
    //     [51.49, -0.1]
    // ];

    const map = L.map('map')
    .setView([-5.3745, -80.72755],
    10);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
    
    function createNumberedIcon(number) {
        const markerHtml = `
            <div class="numbered-div-icon">
                <img src="https://unpkg.com/leaflet@1.7.1/dist/images/marker-icon.png" />
                <div class="number">${number}</div>
            </div>
        `;
        return L.divIcon({
            className: 'div_marker_icon',
            html: markerHtml,
            iconSize: [10, 10],
            iconAnchor: [15, 15]
        });
    }

    const fn_cargarCoordenadas = () => {
        $.ajax({
            url: `${base_url}/seguimiento/coordenadaslist`,
            type: "POST",
            dataType: "JSON",
            beforeSend: function(){
                $('#divover_inspectores').loading({message: 'Cargando...'});
            },
        })
        .done((data) => {
            $('#divover_inspectores').loading('stop');
            const { status, dataCoordenadas } = data;

            if(status){
                
                let count = 0;
                let dataInspectores = '';

                for (let i = 0; i < dataCoordenadas.length; i++) {
                    count++;
                    const element = dataCoordenadas[i];
                    const { ejex, ejey, supervisor } = element;
                    const ubicacion = [ ejex, ejey ];
                    const marker = L.marker(ubicacion, { icon: createNumberedIcon(count)}).addTo(map);
                    marker.bindPopup(`<b>${supervisor}</b>`);
                    // marker.openPopup();

                    marker.on('popupclose', function (e) {
                        marker.openPopup();
                    });

                    dataInspectores += `<p class="border-bottom border-secondary"> <span class="font-weight-bold">${count}</span> : ${supervisor}</p>`;
                }
                $('#div_inspectores_legen').html(dataInspectores);
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