<?php


namespace Application\Entities;


class Product {
    public function __construct(
        private int $id,
        private int $userId,
        private int $categoryId,
        private string $name,
        private string $manufacturer,
        private string $description
    ) {
    }

    public function getId(): int {
        return $this->id;
    }

    public function getUserId(): int {
        return $this->userId;
    }

    public function getCategoryId(): int {
        return $this->categoryId;
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