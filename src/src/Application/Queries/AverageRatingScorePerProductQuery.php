<?php


namespace Application\Queries;


use Application\Interfaces\RatingRepository;

class AverageRatingScorePerProductQuery {
    public function __construct(
        private RatingRepository $ratingRepository
    ) {
    }

    public function execute(int $pid): float {
        return $this->ratingRepository->averageRatingScorePerProduct($pid);
    }


}