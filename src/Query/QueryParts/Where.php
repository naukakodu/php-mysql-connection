<?php

namespace Naukakodu\PhpMysqlConnection\Query\QueryParts;

use Naukakodu\PhpMysqlConnection\Query\QueryPart;

class Where extends QueryPart
{
    protected array $conditions = [];

    public function where(string $column, string $operator, mixed $value): void
    {
        $value = is_numeric($value) ? $value : "'" . addslashes((string) $value) . "'";
        $this->conditions[] = "{$column} {$operator} {$value}";
    }

    public function toSql(): string
    {
        return $this->conditions
            ? 'WHERE ' . implode(' AND ', $this->conditions)
            : '';
    }
}
