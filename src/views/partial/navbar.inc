<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="w-75 container-fluid">
        <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
            <ul class="navbar-nav me-auto">
                <li class="nav-item active">
                    <?php $link("Home", "Home", "Index", cssClass: 'nav-item nav-link'); ?>
                </li>
                <li class="nav-item">
                    <?php $link("Products", "Products", "Index", cssClass: 'nav-item nav-link'); ?>
                </li>
                <div class="form-inline my-2 my-lg-0">
                    <?php if (isset($data["user"])) { ?>
                        <?php $link("Add", "Products", "Create", cssClass: 'btn btn-success my-2 my-sm-0'); ?>
                    <?php } ?>
                </div>
            </ul>
        </div>
        <div class="mx-auto order-0">
            <a class="navbar-brand mx-auto" href="/">PRP</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target=".dual-collapse2">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
            <ul class="navbar-nav ms-auto">
                <?php if (!isset($data["user"])) { ?>
                    <li class="nav-item">
                        <?php $link("Login", "User", "Login", cssClass: 'nav-item nav-link'); ?>
                    </li>
                    <li class="nav-item">
                        <?php $link("Register", "User", "Register", cssClass: 'nav-item nav-link'); ?>
                    </li>
                <?php } else { ?>
                    <?php $beginForm('User', 'LogOut', method: 'post', cssClass: 'form-inline'); ?>
                    <span class="navbar-text me-2">Welcome, <strong><?php $htmlOut($data["user"]->getUsername()); ?></strong>.</span>
                    <button class="btn btn-secondary">Log out</button>
                    <?php $endForm(); ?>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>