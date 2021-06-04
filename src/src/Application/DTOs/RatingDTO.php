<?php


namespace Application\DTOs;


class RatingDTO {
    public function __construct(
        private int $id,
        private ProductDTO $product,
        private UserDTO $user,
        private float $score,
        private \DateTime $created,
        private ?string $title,
        private ?string $content
    ) {
    }

    public function getId(): int {
        return $this->id;
    }

    public function getProduct(): ProductDTO {
        return $this->product;
    }

    public function getUser(): UserDTO {
        return $this->user;
    }

    public function getScore(): float {
        return $this->score;
    }

    public function getCreated(): \DateTime {
        return $this->created;
    }

    public function getTitle(): ?string {
        return $this->title;
    }

    public function getContent(): ?string {
        return $this->content;
    }


}