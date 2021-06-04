<?php


namespace Application\Commands;


use Application\Interfaces\UserRepository;

class RegisterCommand {

    public function __construct(private UserRepository $userRepository) {
    }

    /**
     * @param string $username
     * @param string $password
     * @return int|null return the id of the new User or null if the username is already in use
     */
    public function execute(string $username, string $password): ?int {
        if ($this->userRepository->findUserByUsername($username) != null) {
            return null;
        }
        return $this->userRepository->insertUser($username, $password);
    }

}