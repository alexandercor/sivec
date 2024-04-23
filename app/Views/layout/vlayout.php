<?php
    $miUrlBase = 'resources/adle';
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $this->renderSection('page_title') ?></title>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <?= link_tag("$miUrlBase/plugins/fontawesome-free/css/all.min.css")?>
        <?= link_tag("$miUrlBase/dist/css/adminlte.min.css")?>
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
        <?= script_tag("resources/bandel/web/js/fn.js") ?>

        <?= $this->renderSection('javascript') ?>

    </body>
</html>