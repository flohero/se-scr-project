<!doctype html>
<html lang="en">
<?php $render('partial/head', $data) ?>
<body>
<?php $render('partial/navbar', $data) ?>
<div class="container mt-3 w-25">
    <h1 class="bd-title">Update Product</h1>
    <?php $beginForm('Products', 'Update', method: 'post', params: ["pid" => $data["product"]->getId()]); ?>
    <?php $product = $data["product"];
    $render("partial/productEditor", [
        "categories" => $data["categories"],
        "name" => $product->getName(),
        "category" => $product->getCategoryId(),
        "manufacturer" => $product->getManufacturer(),
        "content" => $product->getDescription(),
    ]) ?>
    <?php $endForm(); ?>
    <?php $render("partial/errors", ["errors" => $data["errors"]]); ?>
</div>
<?php $render('partial/footer', $data) ?>
</body>

</html>