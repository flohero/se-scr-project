<!doctype html>
<html lang="en">
<?php $render('partial/head', $data) ?>
<body>
<?php $render('partial/navbar', $data) ?>
<div class="container mt-5 mb-5 w-75 d-flex flex-column flex-wrap justify-content-center">
    <div class="container-fluid mb-3">

        <?php $beginForm('Products', 'Search', method: 'post', params: ["cid" => ($data["selectedCategory"] ?? null)],
            cssClass: "row g-3"); ?>
        <div class="col-auto">
            <label for="search" class="visually-hidden">Password</label>
            <input type="text" class="form-control" id="search" name="search" placeholder="Start Typing" autofocus
                   required
                   <?php if (isset($data["search"])) echo 'value="' . $htmlOut($data["search"]) . '"'; ?>
            >
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3">Search</button>
        </div>
        <?php $endForm(); ?>
        <?php $link("All", "Products", "Index",
            cssClass: ("btn " . (isset($data["selectedCategory"]) ? "btn-outline-primary" : "btn-primary"))) ?>
        <?php foreach ($data["categories"] as $category) { ?>
            <?php $link($category->getName(), "Products", "Index", params: ["cid" => $category->getId()],
                cssClass: "btn " . (isset($data["selectedCategory"]) && $data["selectedCategory"] == $category->getId()
                    ? "btn-primary" : "btn-outline-primary")) ?>
        <?php } ?>
    </div>
    <?php if (count($data['products']) == 0) { ?>
        <h2>Nothing Here</h2>
    <?php } ?>
    <?php foreach ($data['products'] as $product) { ?>
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title"><?php echo $htmlOut($product->getName()) ?></h5>
                <h6 class="card-subtitle mb-2 text-muted">By <?php echo $htmlOut($product->getManufacturer()) ?></h6>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Rating:
                    <?php echo number_format($product->getAverageRating(), decimals: 2); ?>/5
                    (<?php echo $htmlOut($product->getRatingCount()); ?>)
                </li>
            </ul>
            <div class="card-body">
                <p class="card-text"><?php echo substr($htmlOut($product->getDescription()), 0, 255) ?>...</p>
                <?php $link("Details", "Products", "Details",
                    params: ["pid" => $product->getId()],
                    cssClass: 'card-link'); ?>
            </div>
        </div>
    <?php } ?>
</div>
<?php $render('partial/footer', $data) ?>
</body>

</html>