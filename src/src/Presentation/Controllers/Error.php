<?php


namespace Presentation\Controllers;


use Presentation\MVC\ActionResult;

class Error extends \Presentation\MVC\Controller {

    public function GET_404() : ActionResult {
        return $this->view("error", [
            "error" => "Page Not Found!"
        ]);
    }
}