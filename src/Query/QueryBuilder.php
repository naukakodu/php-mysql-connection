<?php

namespace Naukakodu\PhpMysqlConnection\Query;

use BadMethodCallException;
use Naukakodu\PhpMysqlConnection\Database;

/**
 * @method static where(string $column, string $operator, mixed $value)
 * @method static limit(int $limit)
 */
class QueryBuilder
{
    protected string $table = '';
    protected array $parts = [];

    public function __construct(public readonly Database $database) {}

    public function table(string $table): static
    {
        $this->table = $table;
        return $this;
    }

    /**
     * Handles dynamic method calls to the class by instantiating a corresponding query part class
     * and delegating the method call to it if it exists.
     *
     * @param string $method The name of the method being called dynamically.
     * @param array $arguments The arguments provided for the dynamic method call.
     * @return static Returns the current instance for method chaining.
     * @throws BadMethodCallException If the method is not supported or does not exist in the target class.
     */
    public function __call(string $method, array $arguments): static
    {
        $class = ucfirst($method);
        $fullClass = "Naukakodu\\PhpMysqlConnection\\Query\\QueryParts\\$class";

        if (!class_exists($fullClass)) {
            throw new BadMethodCallException("Metoda {$method} nie jest obsługiwana.");
        }

        if (!isset($this->parts[$class])) {
            $this->parts[$class] = new $fullClass($this);
        }

        if (!method_exists($this->parts[$class], $method)) {
            throw new BadMethodCallException("Metoda {$method} nie istnieje w klasie {$class}.");
        }

        $this->parts[$class]->$method(...$arguments);

        return $this;
    }

    public function toSql(): string
    {
        $sql = "SELECT * FROM {$this->table}";

        foreach ($this->parts as $part) {
            $partSql = $part->toSql();
            if ($partSql) {
                $sql .= ' ' . $partSql;
            }
        }

        return trim($sql);
    }

    public function execute(): array
    {
        return $this->database->fetchAll($this->toSql());
    }
}