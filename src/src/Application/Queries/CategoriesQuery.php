<?php


namespace Application\Queries;


use Application\DTOs\CategoryDTO;
use Application\Interfaces\CategoryRepository;

class CategoriesQuery {
    public function __construct(
        private CategoryRepository $categoryRepository
    ) {
    }

    public function execute(): array {
        $categories = $this->categoryRepository->findAllCategories();
        $categoryDTOs = [];
        foreach ($categories as $category) {
            $categoryDTOs[] = new CategoryDTO($category->getId(), $category->getName());
        }
        return $categoryDTOs;
    }

}