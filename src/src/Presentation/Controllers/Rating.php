<?php


namespace Presentation\Controllers;


use Application\Commands\CreateRatingCommand;
use Application\Queries\LoggedInUserQuery;
use Application\Queries\ProductDetailsQuery;
use Application\Queries\RatingByUserAndProductQuery;
use Application\Queries\RatingsByProductQuery;
use Presentation\MVC\ActionResult;
use Presentation\MVC\Controller;

class Rating extends Controller {
    const PRODUCT_ID = "pid";
    const SCORE = "score";
    const CONTENT = "content";
    const TITLE = "title";

    public function __construct(
        private LoggedInUserQuery $loggedInUserQuery,
        private CreateRatingCommand $createRatingCommand,
        private ProductDetailsQuery $productDetailsQuery,
        private RatingsByProductQuery $ratingsByProductQuery,
        private RatingByUserAndProductQuery $ratingByUserAndProduct
    ) {
    }

    public function POST_Create(): ?ActionResult {
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
        if(isset($rating)) {
            $errors[] = "Rating already exists";
        }
        $score = null;
        if (!$this->tryGetParam(self::SCORE, $score)) {
            $errors[] = "Score is required";
        }
        $title = null;
        $this->tryGetParam(self::TITLE, $title);
        $content = null;
        $this->tryGetParam(self::CONTENT, $content);
        if(strlen($title) > 255) {
            $errors[] = "Title must be less than 256 characters";
        }
        if(strlen($content) > 1000) {
            $errors[] = "Content must be less than 1001 characters";
        }
        if (count($errors) == 0) {

            $id = $this->createRatingCommand->execute($pid, $score, $title, $content);
            if (!isset($id)) {
                $errors[] = "Could not submit rating";
            }
            return $this->redirect("Products", "Details", [self::PRODUCT_ID => $pid]);
        }
        return $this->view("productDetails", [
            "product" => $this->productDetailsQuery->execute($pid),
            "user" => $user,
            "ratings" => $this->ratingsByProductQuery->execute($pid),
            "errors" => $errors
        ]);
    }


}