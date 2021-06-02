<?php


namespace Application\Entities;


class Rating {
    public function __construct(
        private int $id,
        private int $productId,
        private int $userId,
        private float $score,
        private ?string $title,
        private ?string $content
    ) {
    }

    public function getId(): int {
        return $this->id;
    }

    public function getProductId(): int {
        return $this->productId;
    }

    public function getUserId(): int {
        return $this->userId;
    }

    public function getScore(): float {
        return $this->score;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getContent(): string {
        return $this->content;
    }



}