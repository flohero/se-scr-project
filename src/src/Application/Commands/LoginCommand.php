<?php

namespace Application\Commands;

use Application\Interfaces\UserRepository;
use Application\Services\AuthenticationService;

class LoginCommand {
    public function __construct(
        private UserRepository $userRepository,
        private AuthenticationService $authenticationService
    ) {
    }

    public function execute(string $username, string $password): bool {
        $user = $this->userRepository->findUserByUsernameAndPassword($username, $password);
        if ($user != null) {
            $this->authenticationService->login($user->getId());
        }
        return $user != null;
    }

}