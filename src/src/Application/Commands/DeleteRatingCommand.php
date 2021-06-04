<?php


namespace Application\Commands;


use Application\Interfaces\RatingRepository;

class DeleteRatingCommand {
    public function __construct(
        private RatingRepository $ratingRepository
    ) {
    }

    public function execute(int $rid): bool {
        return $this->ratingRepository->deleteRating($rid);
    }
}