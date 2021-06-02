<!doctype html>
<html lang="en">
<?php $render('partial/head', $data) ?>
<body>
<?php $render('partial/navbar', $data) ?>
<div class="container mt-3">
    <?php $beginForm('User', 'Login', method: 'post'); ?>
    <div>
        <label for="username" class="form-label">Username</label>
        <input id="username" name="username" placeholder="Username" type="text" class="form-control">
    </div>
    <div>
        <label for="password" class="form-label">Password</label>
        <input id="password" name="password" placeholder="Password" type="password" class="form-control">
    </div>
    <?php $endForm(); ?>
</div>
<?php $render('partial/footer', $data) ?>
</body>

</html>