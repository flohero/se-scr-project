<?php


namespace Presentation\Controllers;


use Application\Queries\LoggedInUserQuery;
use Presentation\MVC\ActionResult;
use Presentation\MVC\Controller;

class Home extends Controller {
    public function __construct(private LoggedInUserQuery $loggedInUserQuery) {
    }

    public function GET_index(): ActionResult {
        return $this->view("home", [
            "user" => $this->loggedInUserQuery->execute()
        ]);
    }
}