<?php


namespace Presentation\Controllers;


use Application\Commands\CreateRatingCommand;
use Application\Commands\DeleteRatingCommand;
use Application\Commands\UpdateRatingCommand;
use Application\Queries\LoggedInUserQuery;
use Application\Queries\ProductDetailsQuery;
use Application\Queries\RatingByIdQuery;
use Application\Queries\RatingByUserAndProductQuery;
use Application\Queries\RatingsByProductQuery;
use Presentation\MVC\ActionResult;
use Presentation\MVC\Controller;

class Rating extends Controller {
    const PRODUCT_ID = "pid";
    const SCORE = "score";
    const CONTENT = "content";
    const TITLE = "title";
    const SCORE_IS_REQUIRED = "Score is required";
    const TITLE_TOO_LONG = "Title must be less than 256 characters";
    const CONTENT_TOO_LONG = "Content must be less than 1001 characters";
    const RATING_DOES_NOT_EXISTS = "Rating does not exists";
    const RATING_ID = "ratingId";
    const THIS_IS_NOT_YOUR_RATING = "This is not your rating";

    public function __construct(
        private LoggedInUserQuery $loggedInUserQuery,
        private CreateRatingCommand $createRatingCommand,
        private ProductDetailsQuery $productDetailsQuery,
        private RatingsByProductQuery $ratingsByProductQuery,
        private RatingByUserAndProductQuery $ratingByUserAndProduct,
        private UpdateRatingCommand $updateRatingCommand,
        private RatingByIdQuery $ratingByIdQuery,
        private DeleteRatingCommand $deleteRatingCommand
    ) {
    }

    public function POST_Create(): ActionResult {
        $user = $this->loggedInUserQuery->execute();
        if ($user == null) {
            return $this->redirect("Home", "Index");
        }
        $errors = [];
        $pid = null;
        if (!$this->tryGetParam(self::PRODUCT_ID, $pid)) {
            $errors[] = "Need a product";
        }
        $rating = $this->ratingByUserAndProduct->execute($user->getId(), $pid);
        if (isset($rating)) {
            $errors[] = "Rating already exists";
        }
        $score = null;
        if (!$this->tryGetParam(self::SCORE, $score)) {
            $errors[] = self::SCORE_IS_REQUIRED;
        }
        $title = null;
        $this->tryGetParam(self::TITLE, $title);
        $content = null;
        $this->tryGetParam(self::CONTENT, $content);
        if (strlen($title) > 255) {
            $errors[] = self::TITLE_TOO_LONG;
        }
        if (strlen($content) > 1000) {
            $errors[] = self::CONTENT_TOO_LONG;
        }
        if (count($errors) == 0) {

            $id = $this->createRatingCommand->execute($pid, $score, $title, $content);
            if (!isset($id)) {
                $errors[] = "Could not submit rating";
            } else {
                return $this->redirect("Products", "Details", [self::PRODUCT_ID => $pid]);
            }
        }
        return $this->view("productDetails", [
            "product" => $this->productDetailsQuery->execute($pid),
            "user" => $user,
            "ratings" => $this->ratingsByProductQuery->execute($pid),
            "errors" => $errors
        ]);
    }

    public function POST_Update(): ActionResult {
        $user = $this->loggedInUserQuery->execute();
        if ($user == null) {
            return $this->redirect("Home", "Index");
        }
        $errors = [];
        $rid = null;
        $rating = null;
        if ($this->tryGetParam(self::RATING_ID, $rid)) {
            $rating = $this->ratingByIdQuery->execute($rid);
            if (!isset($rating)) {
                $errors[] = self::RATING_DOES_NOT_EXISTS;
            } elseif ($user->getId() !== $rating->getUser()->getId()) {
                $errors[] = self::THIS_IS_NOT_YOUR_RATING;
            }
        } else {
            $errors[] = self::RATING_DOES_NOT_EXISTS;
        }
        $score = null;
        if (!$this->tryGetParam(self::SCORE, $score)) {
            $errors[] = self::SCORE_IS_REQUIRED;
        }
        $title = null;
        $this->tryGetParam(self::TITLE, $title);
        $content = null;
        $this->tryGetParam(self::CONTENT, $content);
        if (strlen($title) > 255) {
            $errors[] = self::TITLE_TOO_LONG;
        }
        if (strlen($content) > 1000) {
            $errors[] = self::CONTENT_TOO_LONG;
        }
        if (count($errors) == 0) {
            $success = $this->updateRatingCommand->execute($rid, $score, $title, $content);
            if (!$success) {
                $errors[] = "Could not update rating";
            } else {
                return $this->redirect("Products", "Details", [self::PRODUCT_ID => $rating->getProduct()->getId()]);
            }
        }
        return $this->view("productDetails", [
            "product" => $this->productDetailsQuery->execute($rating->getProduct()->getId()),
            "user" => $user,
            "ratings" => $this->ratingsByProductQuery->execute($rating->getProduct()->getId()),
            "errors" => $errors
        ]);
    }

    public function POST_Delete(): ActionResult {
        $user = $this->loggedInUserQuery->execute();

        if ($user == null) {
            return $this->redirect("Home", "Index");
        }
        $rid = null;
        $errors = [];
        $rating = null;
        if ($this->tryGetParam(self::RATING_ID, $rid)) {
            $rating = $this->ratingByIdQuery->execute($rid);
            if (!isset($rating)) {
                $errors[] = self::RATING_DOES_NOT_EXISTS;
            } elseif ($user->getId() !== $rating->getUser()->getId()) {
                $errors[] = self::THIS_IS_NOT_YOUR_RATING;
            }
        } else {
            $errors[] = self::RATING_DOES_NOT_EXISTS;
        }
        if (count($errors) > 0) {
            return $this->view("productDetails", [
                "product" => $this->productDetailsQuery->execute($rating->getProduct()->getId()),
                "user" => $user,
                "ratings" => $this->ratingsByProductQuery->execute($rating->getProduct()->getId()),
                "errors" => $errors
            ]);
        }
        $this->deleteRatingCommand->execute($rating->getId());
        return $this->redirect("Products", "Details", [
            self::PRODUCT_ID => $rating->getProduct()->getId()
        ]);
    }
}