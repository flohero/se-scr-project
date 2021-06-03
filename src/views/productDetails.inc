<!doctype html>
<html lang="en">
<?php $render('partial/head', $data) ?>
<body>
<?php $render('partial/navbar', $data) ?>
<div class="container mt-5 d-flex flex-column justify-content-center">
    <h1 class="bd-title"><?php echo $data["product"]->getName() ?></h1>
    <p class="text-muted">Produced by <?php echo $data["product"]->getManufacturer() ?></p>
    <ul class="nav nav-tabs nav-fill">
        <li class="nav-item">
            <button class="nav-link active" id="about-tab" data-bs-toggle="tab"
                    data-bs-target="#about" type="button" role="tab">About
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="reviews-tab" data-bs-toggle="tab"
                    data-bs-target="#reviews" type="button" role="tab">Reviews
            </button>
        </li>
    </ul>
    <div class="tab-content mt-5">
        <div class="tab-pane fade show active" id="about" role="tabpanel">
            <p><?php echo $data["product"]->getDescription(); ?></p>
            <p class="text-muted">Created by <?php echo $data["product"]->getUser()->getUsername() ?></p>
        </div>
        <div class="tab-pane fade show" id="reviews" role="tabpanel">
            <?php if ($data["user"] != null) { ?>
                <?php $beginForm('Reviews', 'Create', method: 'post'); ?>
                <h1>Review this Product</h1>
                <div class="rating">
                    <label>
                        <input type="radio" name="stars" value="1"/>
                        <span class="icon">★</span>
                    </label>
                    <label>
                        <input type="radio" name="stars" value="2"/>
                        <span class="icon">★</span>
                        <span class="icon">★</span>
                    </label>
                    <label>
                        <input type="radio" name="stars" value="3"/>
                        <span class="icon">★</span>
                        <span class="icon">★</span>
                        <span class="icon">★</span>
                    </label>
                    <label>
                        <input type="radio" name="stars" value="4"/>
                        <span class="icon">★</span>
                        <span class="icon">★</span>
                        <span class="icon">★</span>
                        <span class="icon">★</span>
                    </label>
                    <label>
                        <input type="radio" name="stars" value="5"/>
                        <span class="icon">★</span>
                        <span class="icon">★</span>
                        <span class="icon">★</span>
                        <span class="icon">★</span>
                        <span class="icon">★</span>
                    </label>
                </div>
                <div class="form-group mt-3">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" placeholder="Title">
                </div>
                <div class="form-group mt-3">
                    <label for="content">Content</label>
                    <textarea class="form-control" id="content" rows="3" placeholder="Your Review"></textarea>
                </div>
                <div class="mt-3 form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <?php $endForm(); ?>
                <hr/>
            <?php } ?>
            <?php if ($data["reviews"] != null && count($data["reviews"]) > 0) { ?>

            <?php } else { ?>
                <p class="text-muted">Looks like nothing is here</p>
            <?php } ?>
        </div>
    </div>
</div>
<?php $render('partial/footer', $data) ?>
</body>
</html>