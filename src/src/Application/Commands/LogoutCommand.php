<?php


namespace Application\Commands;


use Application\Services\AuthenticationService;

class LogoutCommand {
    public function __construct(private AuthenticationService $authenticationService) {
    }

    public function execute() {
        $this->authenticationService->logout();
    }
}