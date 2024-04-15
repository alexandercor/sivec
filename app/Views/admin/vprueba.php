<ul>
    <?php foreach($provincias->getResult() as $pro): ?>
        <li><?= $pro->nombre_departamento; ?> </li>
    <?php endforeach ?>
</ul>
