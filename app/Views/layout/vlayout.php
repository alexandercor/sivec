<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $this->renderSection('page_title') ?></title>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <?= link_tag("$miUrlBase/plugins/fontawesome-free/css/all.min.css")?>
        <?= link_tag("$miUrlBase/dist/css/adminlte.min.css")?>

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

        <?= script_tag("$miUrlBase/plugins/jquery/jquery.min.js") ?>
        <?= script_tag("$miUrlBase/plugins/bootstrap/js/bootstrap.bundle.min.js") ?>
        <?= script_tag("$miUrlBase/dist/js/adminlte.min.js") ?>

        <?= $this->renderSection('javascript') ?>

    </body>
</html>