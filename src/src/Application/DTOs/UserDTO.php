<?php


namespace Application\DTOs;


class UserDTO {

    public function __construct(private int $id, private string $username) {
    }

    public function getId(): int {
        return $this->id;
    }

    public function getUsername(): string {
        return $this->username;
    }


}