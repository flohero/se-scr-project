<?php


namespace Application\Commands;


use Application\Interfaces\RatingRepository;

class UpdateRatingCommand {
    public function __construct(
        private RatingRepository $ratingRepository
    ) {
    }

    public function execute(int $rid, int $score, ?string $title, ?string $content): bool {
        return $this->ratingRepository->updateRating($rid, $score, $title, $content);
    }

}