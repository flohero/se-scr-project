<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <!-- TODO: navigation home -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar">
            <nav class="navbar-nav me-auto">
                <?php $link("Home", "Home", "Index", cssClass: 'nav-item nav-link'); ?>
                <?php $link("Login", "Login", "Login", cssClass: 'nav-item nav-link'); ?>
            </nav>
            <!-- TODO: navigation user -->
        </div>
    </div>
</nav>