<?php include_once(VIEWS .'header.php')?>
    <h2 class="text-center"><?= $data['subtitle'] ?></h2>
    <img src="<?= ROOT ?>img/<?= $data['data']->image ?>" class="rounded float-right">
    <h4>Precio:</h4>
    <p><?= number_format($data['data']->price) ?>&euro;</p>

    <?php if($data['data']->type == 1) : ?>
        <h4>Descripcion:</h4>
        <?= html_entity_decode($data['data']->description) ?>
        <h4>A quien va dirigido:</h4>
        <p><?= $data['data']->people ?></p>
        <h4>Precio:</h4>
        <p><?= $data['data']->objetives ?></p>
        <h4>Que es necesario?</h4>
        <p><?= $data['data']->necesites ?></p>
    <?php elseif($data['data']->type == 2) : ?>
        <h4>Autor:</h4>
        <p><?= $data['data']->author ?></p>
        <h4>Editorial:</h4>
        <p><?= $data['data']->publisher ?></p>
        <h4>Paginas:</h4>
        <p><?= $data['data']->pages ?></p>
        <h4>Resumen:</h4>
        <?= html_entity_decode($data['data']->description) ?>
    <?php endif ?>
    <a href="<?= ROOT . $data['back']?>" class="btn btn-outline-success">Volver al listado de productos</a>

    <a href="<?= ROOT ?>cart/addProducts/<?= $data['data']->id ?>/<?= $data['user'] ?>" class="btn btn-outline-info"><i class="fal fa-cart-plus"></i></a>
<?php include_once(VIEWS .'footer.php')?>