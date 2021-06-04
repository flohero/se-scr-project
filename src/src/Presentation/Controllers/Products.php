<?php


namespace Presentation\Controllers;


use Application\Commands\CreateProductCommand;
use Application\Queries\CategoriesQuery;
use Application\Queries\LoggedInUserQuery;
use Application\Queries\ProductDetailsQuery;
use Application\Queries\ProductsQuery;
use Application\Queries\RatingByUserAndProductQuery;
use Application\Queries\RatingsByProductQuery;
use Presentation\MVC\ActionResult;
use Presentation\MVC\Controller;

class Products extends Controller {
    const PRODUCT_NOT_FOUND = "Product Not Found";
    const PRODUCT_ID = "pid";
    const CATEGORY_ID = "cid";
    const SEARCH = "search";
    const NAME = "name";
    const MANUFACTURER = "manufacturer";
    const CATEGORY = "category";
    const CONTENT = "content";
    const ERRORS = "errors";

    public function __construct(
        private ProductsQuery $productsQuery,
        private LoggedInUserQuery $loggedInUserQuery,
        private ProductDetailsQuery $productDetailsQuery,
        private RatingsByProductQuery $ratingsByProductQuery,
        private RatingByUserAndProductQuery $ratingByUserAndProductQuery,
        private CategoriesQuery $categoriesQuery,
        private CreateProductCommand $createProductCommand
    ) {
    }

    public function GET_Index(): ActionResult {
        $this->tryGetParam(self::CATEGORY_ID, $cid);
        $this->tryGetParam(self::SEARCH, $search);
        $cid = trim($cid) === "" ? null : $cid;
        $search = trim($search) == "" ? null : $search;
        $data = [
            "products" => $this->productsQuery->execute($cid, $search),
            "categories" => $this->categoriesQuery->execute(),
            "user" => $this->loggedInUserQuery->execute()
        ];
        if (isset($cid)) {
            $data["selectedCategory"] = $cid;
        }
        if (isset($search)) {
            $data["search"] = $search;
        }
        return $this->view("productlist", $data);
    }

    public function POST_Search(): ActionResult {
        $params = [];
        if ($this->tryGetParam(self::CATEGORY_ID, $cid)) {
            $params[self::CATEGORY_ID] = $cid;
        }
        if ($this->tryGetParam(self::SEARCH, $search)) {
            $params[self::SEARCH] = $search;
        }
        return $this->redirect("Products", "Index", params: $params);
    }

    public function Get_Details(): ActionResult {
        $errors = [];
        $pidstr = "";
        $product = null;
        $pid = 0;
        if (!$this->tryGetParam(self::PRODUCT_ID, $pidstr)) {
            $errors[] = self::PRODUCT_NOT_FOUND;
        } else {
            $pid = intval($pidstr);
            if ($pid != 0) {
                $product = $this->productDetailsQuery->execute($pid);
            }
            if ($product == null) {
                $errors[] = self::PRODUCT_NOT_FOUND;
            }
        }
        if (count($errors) > 0) {
            return $this->redirect("Error", "Index", $errors);
        }
        $user = $this->loggedInUserQuery->execute();
        return $this->view("productDetails", [
            "user" => $user,
            "product" => $product,
            "ratings" => $this->ratingsByProductQuery->execute($pid),
            "userRating" => $user != null ? $this->ratingByUserAndProductQuery->execute($user->getId(), $pid) : null
        ]);
    }

    public function GET_Create(): ActionResult {
        $user = $this->loggedInUserQuery->execute();

        if ($user == null) {
            return $this->redirect("Home", "Index");
        }
        $data = [
            "user" => $this->loggedInUserQuery->execute(),
            "categories" => $this->categoriesQuery->execute(),
        ];
        if($this->tryGetParam(self::NAME, $name)) {
            $data[self::NAME] = $name;
        }
        if($this->tryGetParam(self::MANUFACTURER, $manufacturer)) {
            $data[self::MANUFACTURER] = $manufacturer;
        }
        if ($this->tryGetParam(self::CATEGORY, $category)) {
            $data[self::CATEGORY] = $category;
        }
        if ($this->tryGetParam(self::CONTENT, $content)) {
            $data[self::CATEGORY] = $content;
        }
        return $this->view("productAdd", $data);
    }

    public function POST_Create(): ActionResult {
        $user = $this->loggedInUserQuery->execute();

        if ($user == null) {
            return $this->redirect("Home", "Index");
        }
        $errors = [];
        if (!$this->tryGetParam(self::NAME, $name)) {
            $errors[] = "Name required";
        }
        if (!$this->tryGetParam(self::MANUFACTURER, $manufacturer)) {
            $errors[] = "Manufacturer required";
        }
        if (!$this->tryGetParam(self::CATEGORY, $category)) {
            $errors[] = "Category required";
        }
        if (!$this->tryGetParam(self::CONTENT, $content)) {
            $errors[] = "Content required";
        }
        if (count($errors) == 0) {
            $pid = $this->createProductCommand->createProduct($category, $name, $manufacturer, $content);
            if (isset($pid)) {
                return $this->redirect("Products", "Details", [
                    self::PRODUCT_ID => $pid
                ]);
            }
            $errors[] = "Could not insert Product";
        }
        return $this->redirect("Products", "Create", params: [
            self::NAME => $name,
            self::MANUFACTURER => $manufacturer,
            self::CATEGORY => $category,
            self::CONTENT => $content,
            self::ERRORS => $errors
        ]);
    }

}