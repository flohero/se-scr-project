<?php


namespace Infrastructure;


use Application\Entities\Product;

class Repository implements \Application\Interfaces\ProductRepository {

    public function __construct(
        private string $server,
        private string $username,
        private string $password,
        private string $database) {
    }

    private function getConnection(): \mysqli {
        $conn = new \mysqli($this->server, $this->username, $this->password, $this->database);
        if (!$conn) {
            die("Unable to connect to database: " . $conn->error);
        }
        return $conn;
    }

    private function executeQuery(\mysqli $conn, $query) {
        $result = $conn->query($query);
        if (!$result) {
            die("Error in Query '$query': " . $conn->error);
        }
        return $result;
    }

    private function executeStatement(\mysqli $conn, $query, $bindFunc) {
        $statement = $conn->prepare($query);
        if (!$statement) {
            die("Error in prepared statement '$query': " . $conn->error);
        }
        $bindFunc($statement);
        if (!$statement->execute()) {
            die("Error executing prepared statement '$query': " . $statement->error);
        }
        return $statement;
    }


    public function findAllProducts(): array {
        $products = [];
        $conn = $this->getConnection();
        $result = $this->executeQuery(
            $conn,
            'SELECT id, userId, name, manufacturer, description FROM products'
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