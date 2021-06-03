<!doctype html>
<html lang="en">
<?php $render('partial/head', $data) ?>
<body>
<?php $render('partial/navbar', $data) ?>
<div class="container mt-3 w-25">
    <?php $beginForm('User', 'Login', method: 'post'); ?>
    <div class="mt-3 form-group">
        <label for="username" class="form-label">Username</label>
        <input id="username" name="username" placeholder="Username" type="text" class="form-control">

    </div>
    <div class="mt-3 form-group">
        <label for="password" class="form-label">Password</label>
        <input id="password" name="password" placeholder="Password" type="password" class="form-control">
    </div>
    <div class="mt-3 form-group">
        <button type="submit" class="btn btn-primary">Submit</button>
        <?php $link("Register", "Register", "Index", cssClass: 'btn btn-secondary'); ?>
    </div>
    <?php $endForm(); ?>
</div>
<?php $render('partial/footer', $data) ?>
</body>

</html>