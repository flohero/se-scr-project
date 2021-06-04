<!doctype html>
<html lang="en">
<?php $render('partial/head', $data) ?>
<body>
<?php $render('partial/navbar', $data) ?>
<div class="container mt-3 w-25">
    <h1 class="bd-title">Create Product</h1>

    <?php $beginForm('Products', 'Create', method: 'post'); ?>
    <div class="mt-3 form-group">
        <label for="name" class="form-label">Name</label>
        <input id="name" name="name" placeholder="Name" type="text" class="form-control" required
            <?php if (isset($data["name"])) echo 'value="' . $data["name"] . '"' ?>>
    </div>
    <div class="mt-3 form-group">
        <label for="manufacturer" class="form-label">Manufacturer</label>
        <input id="manufacturer" name="manufacturer" placeholder="Manufacturer" type="text" class="form-control"
               required <?php if (isset($data["name"])) echo 'value="' . $data["manufacturer"] . '"' ?>>
    </div>
    <div class="mt-3 form-group">
        <label for="category" class="form-label">Category</label>
        <select id="category" name="category" class="form-control" required>
            <?php foreach ($data["categories"] as $category) { ?>
                <option value="<?php echo $category->getId() ?>"
                    <?php if (isset($data["category"]) && $data["category"] == $category->getId()) echo "selected" ?>>
                    <?php echo $category->getName() ?>
                </option>
            <?php } ?>
        </select>
    </div>
    <div class="mt-3 form-group">
        <label for="content" class="form-label">Description</label>
        <textarea id="content" name="content" placeholder="Content" class="form-control" required><?php if (isset($data["name"])) echo $data["content"] ?></textarea>
    </div>
    <div class="mt-3 form-group">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
    <?php $endForm(); ?>
    <?php $render("partial/errors", ["errors" => $data["errors"]]); ?>
</div>
<?php $render('partial/footer', $data) ?>
</body>

</html>