<?php if (isset($data["errors"]) && count($data["errors"]) > 0) { ?>
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