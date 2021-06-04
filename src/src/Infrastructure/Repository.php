<?php


namespace Infrastructure;


use Application\Entities\Product;
use Application\Entities\Rating;
use Application\Entities\User;
use Application\Interfaces\ProductRepository;
use Application\Interfaces\RatingRepository;
use Application\Interfaces\UserRepository;

class Repository implements ProductRepository, UserRepository, RatingRepository {

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

    public function findProductById(int $pid): ?Product {
        $conn = $this->getConnection();
        $statement = $this->executeStatement(
            $conn,
            'SELECT id, userId, name, manufacturer, description FROM products WHERE id = ?',
            function (\mysqli_stmt $stmt) use ($pid) {
                $stmt->bind_param('i', $pid);
            }
        );
        $product = null;
        $statement->bind_result($id, $userId, $name, $manufacturer, $description);
        if ($statement->fetch()) {
            $product = new Product($id, $userId, $name, $manufacturer, $description);
        }
        return $product;
    }

    public function insertUser(string $username, string $password): int {
        $hash = password_hash($password, PASSWORD_DEFAULT);
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
        if ($statement->fetch()) {
            $user = new User($id, $username, $password);
        }
        return $user;
    }

    public function findUserByUsernameAndPassword(string $username, string $password): ?User {
        $user = $this->findUserByUsername($username);
        if ($user != null && !password_verify($password, $user->getPassword())) {
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
        if ($statement->fetch()) {
            $user = new User($id, $username, $password);
        }
        return $user;
    }

    /**
     * @throws \Exception
     */
    public function findRatingsByProduct(int $rid): array {
        $conn = $this->getConnection();
        $statement = $this->executeStatement(
            $conn,
            'SELECT id, productId, userId, score, created, title, content FROM ratings WHERE productId = ? ORDER BY created',
            function (\mysqli_stmt $stmt) use ($rid) {
                $stmt->bind_param('i', $rid);
            }
        );
        $ratings = [];
        $statement->bind_result($id, $productId, $userId, $score, $created, $title, $content);
        while ($statement->fetch()) {
            $ratings[] = new Rating($id, $productId, $userId, $score, new \DateTime($created), $title, $content);
        }
        return $ratings;
    }

    public function insertRating(int $productId, int $userId, int $score, ?string $title, ?string $content): int {
        $conn = $this->getConnection();
        $statement = $this->executeStatement(
            $conn,
            'INSERT INTO ratings (productId, userId, score, title, content) VALUES (?, ?, ?, ?, ?)',
            function (\mysqli_stmt $stmt) use ($productId, $userId, $score, $title, $content) {
                $stmt->bind_param('iiiss', $productId, $userId, $score,
                    $title, $content);
            }
        );
        return $statement->insert_id;
    }

    /**
     * @throws \Exception
     */
    public function findRatingByUserAndProduct(int $userId, int $pid): ?Rating {
        $conn = $this->getConnection();
        $statement = $this->executeStatement(
            $conn,
            'SELECT id, productId, userId, score, created, title, content FROM ratings WHERE userId = ? AND productId = ?',
            function (\mysqli_stmt $stmt) use($userId, $pid) {
                $stmt->bind_param("ii", $userId, $pid);
            }
        );
        $statement->bind_result($id, $productId, $userId, $score, $created, $title, $content);
        $rating = null;
        if($statement->fetch()) {
            $rating = new Rating($id, $productId, $userId, $score, new \DateTime($created), $title, $content);
        }
        return $rating;
    }
}