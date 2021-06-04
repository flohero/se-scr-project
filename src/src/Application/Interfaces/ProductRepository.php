<?php


namespace Application\Interfaces;


use Application\Entities\Product;

interface ProductRepository {

    public function findAllProducts(): array;

    public function findAllProductsByName(?string $filter): array;

    public function findProductById(int $pid): ?Product;

    public function findAllProductsByCategory(int $cid): array;

    public function findAllProductsByCategoryAndName(int $cid, ?string $filter): array;

    public function insertProduct(int $userId, int $categoryId, string $name, string $manufacturer, string $description): ?int;

    public function updateProduct(int $pid, int $category, string $name, string $manufacturer, string $content): bool;
}