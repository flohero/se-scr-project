<?php


namespace Presentation\Controllers;


use Application\Commands\LoginCommand;
use Application\Commands\LogoutCommand;
use Application\Commands\RegisterCommand;
use Application\Queries\LoggedInUserQuery;
use Presentation\MVC\ActionResult;
use Presentation\MVC\Controller;

class User extends Controller {
    public function __construct(
        private RegisterCommand $registerCommand,
        private LoginCommand $loginCommand,
        private LoggedInUserQuery $loggedInUserQuery,
        private LogoutCommand $logoutCommand
    ) {
    }

    private function userLoggedIn(): bool {
        return $this->loggedInUserQuery->execute() != null;
    }

    public function GET_Login(): ActionResult {
        if ($this->userLoggedIn()) {
            return $this->redirect("Home", "Index");
        }
        return $this->view("login", []);
    }

    public function POST_Login(): ActionResult {
        if ($this->userLoggedIn()) {
            return $this->redirect("Home", "Index");
        }
        $username = $this->getParam("username");
        $password = $this->getParam("password");
        $loggedIn = $this->loginCommand->execute($username, $password);
        if (!$loggedIn) {
            return $this->view("login", [
                "username" => $username,
                "errors" => ["Invalid Username/Password"]
            ]);
        }
        return $this->redirect("Home", "Index");
    }

    public function POST_Logout(): ActionResult {
        $this->logoutCommand->execute();
        return $this->redirect("Home", "Index");
    }

    public function GET_Register(): ActionResult {
        if ($this->userLoggedIn()) {
            return $this->redirect("Home", "Index");
        }
        return $this->view("register", []);
    }

    public function POST_Register(): ActionResult {
        if ($this->userLoggedIn()) {
            return $this->redirect("Home", "Index");
        }
        $username = $this->getParam("username");
        $password = $this->getParam("password");
        $repeatPassword = $this->getParam("repeat-password");
        $errors = array();
        if (strlen($username) < 3) {
            array_push($errors, "Username has to be longer than 2 characters");
        }
        if (strlen($username) > 45) {
            array_push($errors, "Username can only have 45 characters");
        }
        if (strlen($password) < 4) {
            array_push($errors, "The password must be at least 4 characters long");
        }
        if (strlen($password) > 255) {
            array_push($errors, "Password can only have 255 characters");
        }
        if ($password !== $repeatPassword) {
            array_push($errors, "Passwords do not match");
        }
        if (count($errors) === 0) {
            $id = $this->registerCommand->execute($username, $password);
            if ($id == null) {
                array_push($errors, "Username already in use");
            }
        }
        if (count($errors) > 0) {
            return $this->view("register", [
                'errors' => $errors,
                'username' => $username
            ]);
        }
        $this->loginCommand->execute($username, $password);
        return $this->redirect("Home", "Index");
    }
}