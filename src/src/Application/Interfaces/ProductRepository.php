<?php


namespace Application\Interfaces;


use Application\Entities\Product;

interface ProductRepository {

    public function findAllProducts(): array;

    public function findAllProductsByName(?string $filter): array;

    public function findProductById(int $pid): ?Product;

    public function findAllProductsByCategory(int $cid): array;

    public function findAllProductsByCategoryAndName(int $cid, ?string $filter): array;
}