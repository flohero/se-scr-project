<?php


namespace Application\Commands;


use Application\Interfaces\RatingRepository;
use Application\Services\AuthenticationService;

class CreateRatingCommand {
    public function __construct(
        private RatingRepository $ratingRepository,
        private AuthenticationService $authenticationService
    ) {
    }

    public function execute(int $productId, int $score, ?string $title, ?string $content): ?int {
        $userId = $this->authenticationService->userId();
        if ($userId == null) {
            return null;
        }
        $title = trim($title);
        $title = $title === "" ? null : $title;
        $content = trim($content);
        $content = $content === "" ? null : $content;
        return $this->ratingRepository->insertRating($productId, $userId, $score, $title, $content);
    }

}