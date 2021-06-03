<?php


namespace Presentation\Controllers;


use Application\Commands\RegisterCommand;
use Presentation\MVC\ActionResult;
use Presentation\MVC\Controller;

class User extends Controller {
    public function __construct(private RegisterCommand $registerCommand) {
    }

    public function GET_Login(): ActionResult {
        return $this->view("login", []);
    }

    public function GET_Register(): ActionResult {
        return $this->view("register", []);
    }

    public function POST_Register(): ActionResult {
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
        //TODO: Check if user is already logged in
        return $this->redirect("Home", "Index");
    }
}