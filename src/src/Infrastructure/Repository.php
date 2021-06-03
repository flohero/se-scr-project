<?php


namespace Infrastructure;


use Application\Entities\Product;
use Application\Entities\User;

class Repository implements \Application\Interfaces\ProductRepository, \Application\Interfaces\UserRepository {

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

    public function insertUser(string $username, string $password): int {
        $hash = password_hash($password,  PASSWORD_DEFAULT);
        $conn = $this->getConnection();
        $statement = $this->executeStatement(
            $conn,
            'INSERT INTO users (username, password) VALUES (?, ?)',
            function (\mysqli_stmt $stmt) use ($username, $hash) {
                $stmt->bind_param('ss', $username, $hash);
            }
        );
        return $statement->insert_id;
    }

    public function findUserByUsername(string $username): ?User {
        $user = null;
        $conn = $this->getConnection();
        $statement = $this->executeStatement(
            $conn,
            'SELECT id, username, password FROM users WHERE username = ?',
            function (\mysqli_stmt $stmt) use ($username) {
                $stmt->bind_param('s', $username);
            }
        );
        $statement->bind_result($id, $username, $password);
        if($statement->fetch()) {
            $user = new User($id, $username, $password);
        }
        return $user;
    }

    public function findUserByUsernameAndPassword(string $username, string $password): ?User {
        $user = $this->findUserByUsername($username);
        if($user != null && !password_verify($password, $user->getPassword())) {
            $user = null;
        }
        return $user;
    }

    public function findUserById(int $id): ?User {
        $conn = $this->getConnection();
        $statement = $this->executeStatement(
            $conn,
            'SELECT id, username, password FROM users WHERE id = ?',
            function (\mysqli_stmt $stmt) use ($id) {
                $stmt->bind_param('i', $id);
            }
        );
        $user = null;
        $statement->bind_result($id, $username, $password);
        if($statement->fetch()) {
            $user = new User($id, $username, $password);
        }
        return $user;
    }
}