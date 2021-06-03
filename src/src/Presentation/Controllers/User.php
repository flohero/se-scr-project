<?php


namespace Presentation\Controllers;


use Presentation\MVC\ActionResult;
use Presentation\MVC\Controller;

class User extends Controller {
    public function __construct() {
    }

    public function GET_Login(): ActionResult {
        return $this->view("login", []);
    }

    public function GET_Register(): ActionResult {
        return $this->view("register", []);
    }

    public function POST_Register(): ActionResult {
        return $this->view("register", []);
    }
}