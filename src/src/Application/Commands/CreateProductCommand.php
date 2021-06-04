<?php


namespace Application\Commands;


use Application\Interfaces\ProductRepository;
use Application\Queries\CategoryByIdQuery;
use Application\Queries\LoggedInUserQuery;

class CreateProductCommand {
    public function __construct(
        private ProductRepository $productRepository,
        private LoggedInUserQuery $loggedInUserQuery,
        private CategoryByIdQuery $categoryByIdQuery
    ) {
    }

    public function execute(int $categoryId, string $name, string $manufacturer, string $description): ?int {
        $user = $this->loggedInUserQuery->execute();
        if (!isset($user)) {
            return null;
        }
        $category = $this->categoryByIdQuery->execute($categoryId);
        if(!isset($category)) {
            return null;
        }
        return $this->productRepository->insertProduct($user->getId(), $categoryId, $name, $manufacturer, $description);
    }

}