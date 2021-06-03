<?php


namespace Application\DTOs;


class ProductDTO {
    public function __construct(
        private int $id,
        private UserDTO $user,
        private string $name,
        private string $manufacturer,
        private string $description
    ) {
    }

    public function getId(): int {
        return $this->id;
    }

    public function getUser(): UserDTO {
        return $this->user;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getManufacturer(): string {
        return $this->manufacturer;
    }

    public function getDescription(): string {
        return $this->description;
    }
}