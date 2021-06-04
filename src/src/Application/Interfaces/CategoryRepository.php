<?php


namespace Application\Interfaces;


use Application\Entities\Category;

interface CategoryRepository {
    public function findCategoryById(int $id): ?Category;

    public function findAllCategories(): array;
}