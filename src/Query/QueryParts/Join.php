<?php

namespace Naukakodu\PhpMysqlConnection\Query\QueryParts;

use Naukakodu\PhpMysqlConnection\Query\QueryPart;

class Join extends QueryPart
{
    protected array $joins = [];

    public function join(string $table, string $firstColumn, string $operator, string $secondColumn): void
    {
        $this->joins[] = "JOIN {$table} ON {$firstColumn} {$operator} {$secondColumn}";
    }

    public function toSql(): string
    {
        return implode(' ', $this->joins);
    }
}