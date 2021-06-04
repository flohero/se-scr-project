<?php


namespace Application\Queries;


use Application\DTOs\UserDTO;
use Application\Interfaces\UserRepository;
use Application\Services\AuthenticationService;

class LoggedInUserQuery {
    public function __construct(
        private UserRepository $userRepository,
        private AuthenticationService $authenticationService
    ) {
    }

    public function execute(): ?UserDTO {
        $id = $this->authenticationService->userId();
        if ($id == null) {
            return null;
        }
        $user = $this->userRepository->findUserById($id);
        if ($user == null) {
            return null;
        }
        return new UserDTO($user->getId(), $user->getUsername());
    }
}