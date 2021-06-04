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
            <button class="nav-link" id="about-tab" data-bs-toggle="tab"
                    data-bs-target="#about" type="button" role="tab">About
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link active" id="reviews-tab" data-bs-toggle="tab"
                    data-bs-target="#reviews" type="button" role="tab">Reviews
            </button>
        </li>
    </ul>
    <div class="tab-content mt-5 mb-5">
        <div class="tab-pane fade show" id="about" role="tabpanel">
            <p><?php echo $data["product"]->getDescription(); ?></p>
            <p class="text-muted">Created by <?php echo $data["product"]->getUser()->getUsername() ?></p>
        </div>
        <div class="tab-pane fade show active" id="reviews" role="tabpanel">
            <?php if ($data["user"] != null) { ?>
                <?php $beginForm('Rating', 'Create', params: ["pid" => $data["product"]->getId()], method: 'post'); ?>
                <h1>Review this Product</h1>
                <?php $render("partial/starRating", []) ?>
                <div class="form-group mt-3">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control" id="title" placeholder="Title">
                </div>
                <div class="form-group mt-3">
                    <label for="content">Content</label>
                    <textarea class="form-control" id="content" name="content" rows="3" placeholder="Your Review"></textarea>
                </div>
                <div class="mt-3 form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <?php $endForm(); ?>
                <?php $render("partial/errors", $data); ?>
                <hr/>
            <?php } ?>
            <?php if ($data["ratings"] != null && count($data["ratings"]) > 0) { ?>
                <?php foreach ($data["ratings"] as $rating) { ?>
                    <div class="card mt-3">
                        <div class="card-body">
                            <?php if ($rating->getTitle() !== null) { ?>
                                <h5 class="card-title"><?php echo $rating->getTitle() ?></h5>
                            <?php } ?>

                            <h5 class="card-title star">
                                <?php for ($score = 0; $score < $rating->getScore(); $score++) { ?>
                                    ★
                                <?php } ?>
                            </h5>
                            <?php if ($rating->getContent() !== null) { ?>
                                <?php echo $rating->getContent() ?>
                            <?php } ?>
                            <h6 class="card-subtitle text-muted mt-3">
                                from <?php echo $rating->getUser()->getUsername() ?>
                                on <?php echo $rating->getCreated()->format('Y-m-d H:i') ?>
                            </h6>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p class="text-muted">Looks like nothing is here</p>
            <?php } ?>
        </div>
    </div>
</div>
<?php $render('partial/footer', $data) ?>
</body>
</html>