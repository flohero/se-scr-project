<?php


namespace Application\Interfaces;


use Application\Entities\Rating;

interface RatingRepository {

    public function findRatingsByProduct(int $rid): array;

    public function insertRating(int $productId, int $userId, int $score, ?string $title, ?string $content): int;

    public function findRatingByUserAndProduct(int $userId, int $pid): ?Rating;
}