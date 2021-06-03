<?php


namespace Application\Interfaces;


use Application\Entities\Product;

interface ProductRepository {

    public function findAllProducts(): array;
}