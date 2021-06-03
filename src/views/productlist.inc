<!doctype html>
<html lang="en">
<?php $render('partial/head', $data) ?>
<body>
<?php $render('partial/navbar', $data) ?>
<div class="container mt-3 mb-5 w-75 d-flex flex-md-row flex-column justify-content-center">
    <?php foreach ($data['products'] as $product) { ?>
        <div class="card mb-3 mx-md-2 w-md-25">
            <div class="card-body">
                <h5 class="card-title"><?php echo $product->getName() ?></h5>
                <h6 class="card-subtitle mb-2 text-muted">By <?php echo $product->getManufacturer() ?></h6>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Rating: <!-- TODO: display rating --></li>
            </ul>
            <div class="card-body">
                <p class="card-text"><?php echo $product->getDescription() ?></p>
                <a href="#" class="card-link"><!-- TODO: link to details page --></a>
            </div>
        </div>
    <?php } ?>
</div>
<?php $render('partial/footer', $data) ?>
</body>

</html>