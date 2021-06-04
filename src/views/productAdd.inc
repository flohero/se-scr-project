<!doctype html>
<html lang="en">
<?php $render('partial/head', $data) ?>
<body>
<?php $render('partial/navbar', $data) ?>
<div class="container mt-3 w-25">
    <h1 class="bd-title">Create Product</h1>

    <?php $beginForm('Products', 'Create', method: 'post'); ?>
    <?php $render("partial/productEditor", $data) ?>
    <?php $endForm(); ?>
    <?php $render("partial/errors", ["errors" => $data["errors"]]); ?>
</div>
<?php $render('partial/footer', $data) ?>
</body>

</html>