<!doctype html>
<html lang="en">
<?php $render('partial/head', $data) ?>
<body>
<?php $render('partial/navbar', $data) ?>
<div class="container mt-3 w-25">
    <h1 class="bd-title">Register</h1>
    <?php $beginForm('User', 'Register', method: 'post'); ?>
    <div class="mt-3 form-group">
        <label for="username" class="form-label">Username</label>
        <input id="username" name="username" placeholder="Username" type="text"
               class="form-control" value="<?php echo $data["username"] ?>" required>
    </div>
    <div class="mt-3 form-group">
        <label for="password" class="form-label">Password</label>
        <input id="password" name="password" placeholder="Password" type="password" class="form-control" required>
    </div>
    <div class="mt-3 form-group">
        <label for="repeat-password" class="form-label">Repeat Password</label>
        <input id="repeat-password" name="repeat-password" placeholder="Repeat Password"
               type="password" class="form-control" required>
    </div>
    <div class="mt-3 form-group">
        <button type="submit" class="btn btn-primary">Submit</button>
        <?php $link("Login", "User", "Login", cssClass: 'btn btn-secondary'); ?>
    </div>
    <?php $endForm(); ?>
    <?php if ($data["errors"] != null && count($data["errors"]) > 0) { ?>
        <div class="alert alert-danger mt-3" role="alert">
            <?php if (count($data["errors"]) > 1) { ?>
                <ul>
                    <?php foreach ($data["errors"] as $error) { ?>
                        <li><?php echo $error ?></li>
                    <?php } ?>
                </ul>
            <?php } else { ?>
                <?php echo $data["errors"][0] ?>
            <?php } ?>
        </div>
    <?php } ?>
</div>

<?php $render('partial/footer', $data) ?>
</body>

</html>