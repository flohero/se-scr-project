<?php


namespace Infrastructure;



class Connection {
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

    public function executeQuery($query) {
        $conn = $this->getConnection();
        $result = $conn->query($query);
        if (!$result) {
            die("Could not execute query: " . $conn->error);
        }
        return $result;
    }

    public function executeStatement($query, $bindFunc) {
        $conn = $this->getConnection();
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

}