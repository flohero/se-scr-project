<?php


namespace Presentation\Controllers;


use Application\Queries\LoggedInUserQuery;
use Application\Queries\ProductDetailsQuery;
use Application\Queries\ProductsQuery;
use Application\Queries\RatingsByProductQuery;
use Presentation\MVC\ActionResult;
use Presentation\MVC\Controller;
use Presentation\MVC\ViewResult;

class Products extends Controller {
    const PRODUCT_NOT_FOUND = "Product Not Found";
    const PRODUCT_ID = "pid";

    public function __construct(
        private ProductsQuery $productsQuery,
        private LoggedInUserQuery $loggedInUserQuery,
        private ProductDetailsQuery $productDetailsQuery,
        private RatingsByProductQuery $ratingsByProductQuery
    ) {
    }

    public function GET_Index(): ViewResult {
        return $this->view("productlist", [
            "products" => $this->productsQuery->execute(),
            "user" =>$this->loggedInUserQuery->execute()
        ]);
    }

    public function Get_Details(): ActionResult {
        $errors = [];
        $pidstr = "";
        $product = null;
        $pid = 0;
        if(!$this->tryGetParam(self::PRODUCT_ID, $pidstr)) {
            $errors[] = self::PRODUCT_NOT_FOUND;
        } else {
            $pid = intval($pidstr);
            if($pid != 0) {
                $product = $this->productDetailsQuery->execute($pid);
            }
            if($product == null) {
                $errors[] = self::PRODUCT_NOT_FOUND;
            }
        }
        if(count($errors) > 0) {
            return $this->redirect("Error", "Index", $errors);
        }
        return $this->view("productDetails", [
            "user" => $this->loggedInUserQuery->execute(),
            "product" => $product,
            "ratings" => $this->ratingsByProductQuery->execute($pid)
        ]);
    }

}