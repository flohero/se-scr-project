<?php


namespace Application\Queries;


use Application\Interfaces\RatingRepository;

class RatingCountPerProductQuery {
    public function __construct(
        private RatingRepository $ratingRepository
    ) {
    }

    public function execute($pid): int {
        return $this->ratingRepository->countRatingPerProduct($pid);
    }
}