<?php


namespace Presentation\Controllers;


use Presentation\MVC\ActionResult;
use Presentation\MVC\Controller;

class Home extends Controller {
    public function __construct() {
    }

    public function GET_index(): ActionResult {
        return $this->view("home", []);
    }
}