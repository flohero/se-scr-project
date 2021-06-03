<?php


namespace Presentation\Controllers;


use Application\Queries\ProductsQuery;
use Presentation\MVC\Controller;
use Presentation\MVC\ViewResult;

class Products extends Controller {
    public function __construct(private ProductsQuery $productsQuery) {
    }

    public function GET_Index(): ViewResult {
        return $this->view("productlist", [
            'products' => $this->productsQuery->execute()
        ]);
    }

}