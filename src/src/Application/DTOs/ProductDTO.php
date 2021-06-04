<?php


namespace Application\DTOs;


class ProductDTO {
    public function __construct(
        private int $id,
        private UserDTO $user,
        private string $name,
        private string $manufacturer,
        private string $description,
        private int $ratingCount,
        private float $averageRating
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

    public function getRatingCount(): int {
        return $this->ratingCount;
    }

    public function getAverageRating(): float {
        return $this->averageRating;
    }

}