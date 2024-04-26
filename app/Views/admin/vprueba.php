<ul>
    <?php foreach($provincias->getResult() as $pro): ?>
        <li><?= $pro->nombre_departamento; ?> </li>
    <?php endforeach ?>
</ul>

<!-- Tabs -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex p-0">
                        <h3 class="card-title p-3">Tabs</h3>
                        <ul class="nav nav-pills ml-auto p-2">
                            <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Tab 1</a></li>
                            <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Tab 2</a></li>
                            <li class="nav-item"><a class="nav-link" href="#tab_3" data-toggle="tab">Tab 3</a></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                1
                            </div>
                            <div class="tab-pane" id="tab_2">
                                2
                            </div>
                            <div class="tab-pane" id="tab_3">
                                3
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>