<?php


namespace Presentation\Controllers;


use Application\Queries\LoggedInUserQuery;
use Application\Queries\ProductsQuery;
use Presentation\MVC\Controller;
use Presentation\MVC\ViewResult;

class Products extends Controller {
    public function __construct(
        private ProductsQuery $productsQuery,
        private LoggedInUserQuery $loggedInUserQuery
    ) {
    }

    public function GET_Index(): ViewResult {
        return $this->view("productlist", [
            "products" => $this->productsQuery->execute(),
            "user" =>$this->loggedInUserQuery->execute()
        ]);
    }

}