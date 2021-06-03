<!doctype html>
<html lang="en">
<?php $render('partial/head', $data) ?>
<body>
<?php $render('partial/navbar', $data) ?>
<div class="container mt-3 w-25">
    <ul>
        <?php foreach ($data['products'] as $product) { ?>
            <li><?php echo $product->getName(); ?></li>
        <?php } ?>
    </ul>
</div>
<?php $render('partial/footer', $data) ?>
</body>

</html>