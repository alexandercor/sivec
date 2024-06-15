<?php
    $miUrlBase = 'resources/adle';
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $this->renderSection('page_title') ?></title>
        <link rel="icon" href="<?= base_url();?>resources/img/logocem.ico" type="image/x-icon">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <?= link_tag("$miUrlBase/plugins/fontawesome-free/css/all.min.css")?>
        <?= link_tag("$miUrlBase/dist/css/adminlte.min.css")?>
        <?= link_tag("$miUrlBase/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css")?>
        <?= link_tag("$miUrlBase/plugins/leaflet/css/leaflet.css")?>
        <?= link_tag("$miUrlBase/plugins/loader/css/jquery.loading.css")?>
        <?= link_tag("resources/bandel/web/css/assets.css")?>

    </head>
    <body class="hold-transition sidebar-mini">

        <div class="wrapper">

            <?= $this->include('layout/vnavbar') ?>

            <?= $this->include('layout/vsidebar') ?>

            <div class="content-wrapper">
                <?= $this->renderSection('contenido') ?>
            </div>

            <?= $this->include('layout/vfooter') ?>

        </div>
        <script type="text/javascript">
            const base_url = "<?php echo base_url(); ?>";
        </script>
        <?= script_tag("$miUrlBase/plugins/jquery/jquery.min.js") ?>
        <?= script_tag("$miUrlBase/plugins/bootstrap/js/bootstrap.bundle.min.js") ?>
        <?= script_tag("$miUrlBase/dist/js/adminlte.min.js") ?>
        <?= script_tag("$miUrlBase/plugins/sweetalert2/sweetalert2.min.js") ?>
        <?= script_tag("$miUrlBase/plugins/leaflet/js/leaflet.js") ?>
        <?= script_tag("$miUrlBase/plugins/leaflet/js/leaflet-heat.js") ?>
        <?= script_tag("$miUrlBase/plugins/loader/js/jquery.loading.min.js") ?>
        <?= script_tag("resources/bandel/web/js/fn.js") ?>

        <script type="text/javascript">
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        </script>
        
        <script type="text/javascript">
            
            $(() => {
                const urlCurrent = window.location.href;
    
                $('ul.nav-sidebar .nav-item a').filter(function() {
                    return this.href == urlCurrent;
                    console.log(this.href);
                }).addClass('active');

                $('ul.nav-sidebar .nav-item .nav-treeview a').filter(function() {
                    return this.href == urlCurrent;
                }).addClass('active');

                $('ul.nav-sidebar .nav-item .nav-treeview a').filter(function() {
                    return this.href == urlCurrent;
                }).parentsUntil("ul.nav-sidebar nav-item > .nav-treeview").children(0).addClass('active');

            })

        </script>
        <?= $this->renderSection('javascript') ?>

    </body>
</html>