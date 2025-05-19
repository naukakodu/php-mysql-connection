<?php

namespace Naukakodu\PhpMysqlConnection;

use Exception;
use Naukakodu\PhpMysqlConnection\Query\QueryBuilder;
use PDO;
use PDOException;
use PDOStatement;

class Database {
    private string $host;
    private string $dbName;
    private string $username;
    private string $password;
    private string $charset;
    private PDO $pdo;

    /**
     * @throws Exception
     */
    public function __construct(string $host, string $dbName, string $username, string $password, string $charset = 'utf8mb4') {
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
    private function connect(): void
    {
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

    public function getConnection(): PDO
    {
        return $this->pdo;
    }

    public function query($sql, $params = []): false|PDOStatement
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function fetchAll($sql, $params = []): array
    {
        return $this->query($sql, $params)->fetchAll();
    }

    public function fetch($sql, $params = []) {
        return $this->query($sql, $params)->fetch();
    }

    public function insert($sql, $params = []): false|string
    {
        $this->query($sql, $params);
        return $this->pdo->lastInsertId();
    }

    public function getQueryBuilder(): QueryBuilder
    {
        return new QueryBuilder($this);
    }
}
