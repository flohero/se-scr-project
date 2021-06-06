<?php


namespace Infrastructure;


use Application\Entities\Category;
use Application\Entities\Product;
use Application\Entities\Rating;
use Application\Entities\User;
use Application\Interfaces\CategoryRepository;
use Application\Interfaces\ProductRepository;
use Application\Interfaces\RatingRepository;
use Application\Interfaces\UserRepository;

class Repository implements ProductRepository, UserRepository, RatingRepository, CategoryRepository {

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

    public function findCategoryById(int $id): ?Category {
        $conn = $this->getConnection();
        $stmt = $this->executeStatement(
            $conn,
            'SELECT id, name FROM categories WHERE id = ?',
            function (\mysqli_stmt $stmt) use ($id) {
                $stmt->bind_param("i", $id);
            }
        );
        $category = null;
        $stmt->bind_result($cid, $name);
        if ($stmt->fetch()) {
            $category = new Category($cid, $name);
        }
        return $category;
    }

    public function findAllCategories(): array {
        $conn = $this->getConnection();
        $query = $this->executeQuery(
            $conn,
            'SELECT id, name FROM categories'
        );
        $categories = [];
        while ($category = $query->fetch_object()) {
            $categories[] = new Category(
                $category->id,
                $category->name,
            );
        }
        return $categories;
    }

    public function findAllProducts(): array {
        $products = [];
        $conn = $this->getConnection();
        $result = $this->executeQuery(
            $conn,
            'SELECT id, userId, categoryId, name, manufacturer, description FROM products'
        );
        while ($product = $result->fetch_object()) {
            $products[] = new Product(
                $product->id,
                $product->userId,
                $product->categoryId,
                $product->name,
                $product->manufacturer,
                $product->description,
            );
        }
        return $products;
    }

    public function findAllProductsByName(?string $filter): array {
        if (isset($filter)) {
            $filter = "%" . $filter . "%";
        } else {
            $filter = "%";
        }
        $products = [];
        $conn = $this->getConnection();
        $result = $this->executeStatement(
            $conn,
            'SELECT id, userId, categoryId, name, manufacturer, description FROM products WHERE (name LIKE ? OR manufacturer LIKE ?)',
            function (\mysqli_stmt $stmt) use ($filter) {
                $stmt->bind_param("ss", $filter, $filter);
            }
        );
        $result->bind_result($id, $userId, $categoryId, $name, $manufacturer, $descirption);
        while ($result->fetch()) {
            $products[] = new Product(
                $id,
                $userId,
                $categoryId,
                $name,
                $manufacturer,
                $descirption,
            );
        }
        return $products;
    }

    public function findProductById(int $pid): ?Product {
        $conn = $this->getConnection();
        $statement = $this->executeStatement(
            $conn,
            'SELECT id, userId, categoryId, name, manufacturer, description FROM products WHERE id = ?',
            function (\mysqli_stmt $stmt) use ($pid) {
                $stmt->bind_param('i', $pid);
            }
        );
        $product = null;
        $statement->bind_result($id, $userId, $categoryId, $name, $manufacturer, $description);
        if ($statement->fetch()) {
            $product = new Product($id, $userId, $categoryId, $name, $manufacturer, $description);
        }
        return $product;
    }

    public function findAllProductsByCategory(int $cid): array {
        $conn = $this->getConnection();
        $statement = $this->executeStatement(
            $conn,
            'SELECT id, userId, categoryId, name, manufacturer, description FROM products WHERE categoryId = ?',
            function (\mysqli_stmt $stmt) use ($cid) {
                $stmt->bind_param('i', $cid);
            }
        );
        $products = [];
        $statement->bind_result($id, $userId, $categoryId, $name, $manufacturer, $description);
        while ($statement->fetch()) {
            $products[] = new Product($id, $userId, $categoryId, $name, $manufacturer, $description);
        }
        return $products;
    }

    public function findAllProductsByCategoryAndName(int $cid, ?string $filter): array {
        if (isset($filter)) {
            $filter = "%" . $filter . "%";
        } else {
            $filter = "%";
        }
        $conn = $this->getConnection();
        $statement = $this->executeStatement(
            $conn,
            'SELECT id, userId, categoryId, name, manufacturer, description FROM products WHERE categoryId = ? AND (name LIKE ? OR manufacturer LIKE ?)',
            function (\mysqli_stmt $stmt) use ($cid, $filter) {
                $stmt->bind_param('iss', $cid, $filter, $filter);
            }
        );
        $products = [];
        $statement->bind_result($id, $userId, $categoryId, $name, $manufacturer, $description);
        while ($statement->fetch()) {
            $products[] = new Product($id, $userId, $categoryId, $name, $manufacturer, $description);
        }
        return $products;
    }

    public function insertProduct(int $userId, int $categoryId, string $name, string $manufacturer, string $description): ?int {
        $conn = $this->getConnection();
        $statement = $this->executeStatement(
            $conn,
            'INSERT INTO products (userId, categoryId, name, manufacturer, description) VALUES (?, ?, ?, ?, ?)',
            function (\mysqli_stmt $stmt) use ($userId, $categoryId, $name, $manufacturer, $description) {
                $stmt->bind_param('iisss', $userId, $categoryId, $name, $manufacturer, $description);
                $stmt->bind_param('iisss', $userId, $categoryId, $name, $manufacturer, $description);
            }
        );
        return $statement->insert_id;
    }

    public function updateProduct(int $pid, int $category, string $name, string $manufacturer, string $content): bool {
        $conn = $this->getConnection();
        $stmt = $this->executeStatement(
            $conn,
            'UPDATE  products SET categoryId = ?, name = ?, manufacturer = ?, description = ? WHERE id = ?',
            function (\mysqli_stmt $stmt) use ($pid, $category, $name, $manufacturer, $content) {
                $stmt->bind_param('isssi', $category, $name, $manufacturer, $content, $pid);
            }
        );
        return $stmt->affected_rows > 0;
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
    public function findRatingsByProduct(int $pid): array {
        $conn = $this->getConnection();
        $statement = $this->executeStatement(
            $conn,
            'SELECT id, productId, userId, score, created, title, content FROM ratings WHERE productId = ? ORDER BY created',
            function (\mysqli_stmt $stmt) use ($pid) {
                $stmt->bind_param('i', $pid);
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
            function (\mysqli_stmt $stmt) use ($userId, $pid) {
                $stmt->bind_param("ii", $userId, $pid);
            }
        );
        $statement->bind_result($id, $productId, $userId, $score, $created, $title, $content);
        $rating = null;
        if ($statement->fetch()) {
            $rating = new Rating($id, $productId, $userId, $score, new \DateTime($created), $title, $content);
        }
        return $rating;
    }

    /**
     * @throws \Exception
     */
    public function findRatingById(int $rid): ?Rating {
        $conn = $this->getConnection();
        $statement = $this->executeStatement(
            $conn,
            'SELECT id, productId, userId, score, created, title, content FROM ratings WHERE id = ?',
            function (\mysqli_stmt $stmt) use ($rid) {
                $stmt->bind_param("i", $rid);
            }
        );
        $statement->bind_result($id, $productId, $userId, $score, $created, $title, $content);
        $rating = null;
        if ($statement->fetch()) {
            $rating = new Rating($id, $productId, $userId, $score, new \DateTime($created), $title, $content);
        }
        return $rating;
    }

    public function updateRating(int $rid, int $score, ?string $title, ?string $content): bool {
        $conn = $this->getConnection();
        $statement = $this->executeStatement(
            $conn,
            'UPDATE ratings SET score = ?, title = ?, content = ? WHERE id = ?',
            function (\mysqli_stmt $stmt) use ($rid, $score, $title, $content) {
                $stmt->bind_param("issi", $score, $title, $content, $rid);
            }
        );
        return $statement->affected_rows > 0;
    }

    public function deleteRating(int $rid): bool {
        $conn = $this->getConnection();
        $statement = $this->executeStatement(
            $conn,
            'DELETE FROM ratings WHERE id = ?',
            function (\mysqli_stmt $stmt) use ($rid) {
                $stmt->bind_param("i", $rid);
            }
        );
        return $statement->affected_rows > 0;
    }

    public function countRatingPerProduct(int $pid): int {
        $conn = $this->getConnection();
        $statement = $this->executeStatement(
            $conn,
            'SELECT COUNT(id) FROM ratings WHERE productId = ?',
            function (\mysqli_stmt $stmt) use ($pid) {
                $stmt->bind_param('i', $pid);
            }
        );
        $statement->bind_result($count);
        if ($statement->fetch()) {
            return $count;
        }
        return 0;
    }

    public function averageRatingScorePerProduct(int $pid): float {
        $conn = $this->getConnection();
        $statement = $this->executeStatement(
            $conn,
            'SELECT AVG(score) AS avg FROM ratings WHERE productId = ?',
            function (\mysqli_stmt $stmt) use ($pid) {
                $stmt->bind_param('i', $pid);
            }
        );
        $statement->bind_result($avg);
        if ($statement->fetch() && isset($avg)) {
            return $avg;
        }
        return 0.0;
    }
}