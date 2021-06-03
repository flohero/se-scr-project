<?php


namespace Infrastructure;


use Application\Entities\Product;

class Repository implements \Application\Interfaces\ProductRepository {
    public function __construct(private Connection $connection) {
    }


    public function findAllProducts(): array {
        $products = [];
        $result = $this->connection->executeQuery(
            'SELECT p_id, u_id, name, manufacturer, description FROM products'
        );
        while ($product = $result->fetch_object()) {
            $products[] = new Product(
                $product->id,
                $product->userId,
                $product->name,
                $product->manufacturer,
                $product->description,
            );
        }
        return $products;
    }
}