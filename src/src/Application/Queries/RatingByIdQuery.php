<?php


namespace Application\Queries;


use Application\DTOs\RatingDTO;
use Application\Interfaces\RatingRepository;

class RatingByIdQuery {
    public function __construct(
        private RatingRepository $ratingRepository,
        private UserByIdQuery $userByIdQuery,
        private ProductDetailsQuery $productDetailsQuery
    ) {
    }

    public function execute(int $rid): ?RatingDTO {
        $rating = $this->ratingRepository->findRatingById($rid);
        $ratingDTO = null;
        if (isset($rating)) {
            $ratingDTO = new RatingDTO(
                $rating->getId(),
                $this->productDetailsQuery->execute($rating->getProductId()),
                $this->userByIdQuery->execute($rating->getUserId()),
                $rating->getScore(),
                $rating->getCreated(),
                $rating->getTitle(),
                $rating->getContent()
            );
        }
        return $ratingDTO;
    }

}