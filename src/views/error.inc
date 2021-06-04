<!doctype html>
<html lang="en">
<?php $render('partial/head', $data) ?>
<body>
<?php $render('partial/navbar', $data) ?>
<div class="container mt-3">
    <h1><?php echo $data["error"]?></h1>
</div>
<?php $render('partial/footer', $data) ?>
</body>

</html>