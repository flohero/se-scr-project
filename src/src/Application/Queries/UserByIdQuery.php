<?php


namespace Application\Queries;


use Application\DTOs\UserDTO;
use Application\Interfaces\UserRepository;

class UserByIdQuery {
    public function __construct(private UserRepository $userRepository) {
    }

    public function execute(int $id): UserDTO {
        $user = $this->userRepository->findUserById($id);
        $userDTO = null;
        if($user != null) {
            $userDTO = new UserDTO($user->getId(), $user->getUsername());
        }
        return $userDTO;
    }

}