<?= $this->extend('layout/vlayout') ?>
<!--  -->
<?= $this->section('page_title') ?> Bienvenido <?= $this->endSection() ?>

<?= $this->section('contenido') ?>

  <h3>mi contenido</h3>

<?= $this->endSection() ?>

<?= $this->section('javascript') ?>

  <script type='text/javascript' >
    // alert('hola')
  </script>

<?= $this->endSection() ?>