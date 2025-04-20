<?php

namespace PhpMysqlConnection;

use Exception;
use PDO;
use PDOException;

class Database {
    private $host;
    private $dbName;
    private $username;
    private $password;
    private $charset;
    private $pdo;

    /**
     * @throws Exception
     */
    public function __construct($host, $dbName, $username, $password, $charset = 'utf8mb4') {
        $this->host     = $host;
        $this->dbName   = $dbName;
        $this->username = $username;
        $this->password = $password;
        $this->charset  = $charset;

        $this->connect();
    }

    /**
     * @throws Exception
     */
    private function connect() {
        $dsn = "mysql:host={$this->host};dbname={$this->dbName};charset={$this->charset}";

        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            throw new Exception("Błąd połączenia z bazą danych: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->pdo;
    }

    public function query($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function fetchAll($sql, $params = []) {
        return $this->query($sql, $params)->fetchAll();
    }

    public function fetch($sql, $params = []) {
        return $this->query($sql, $params)->fetch();
    }

    public function insert($sql, $params = []) {
        $this->query($sql, $params);
        return $this->pdo->lastInsertId();
    }
}
