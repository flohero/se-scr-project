<?php


namespace Application\Queries;


use Application\DTOs\CategoryDTO;
use Application\Interfaces\CategoryRepository;

class CategoryByIdQuery {
    public function __construct(
        private CategoryRepository $categoryRepository
    ) {
    }

    public function execute(int $categoryId): ?CategoryDTO {
        $category = $this->categoryRepository->findCategoryById($categoryId);
        $categoryDTO = null;
        if(isset($category)) {
            $categoryDTO = new CategoryDTO(
                $category->getId(),
                $category->getName(),
            );
        }
        return $categoryDTO;
    }

}