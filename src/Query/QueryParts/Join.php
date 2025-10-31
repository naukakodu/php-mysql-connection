<?php

namespace Naukakodu\PhpMysqlConnection\Query\QueryParts;

use InvalidArgumentException;
use Naukakodu\PhpMysqlConnection\Query\QueryPart;

class Join extends QueryPart
{
    protected array $joins = [];

    public function join(string $table, string $firstColumn, string $operator, string $secondColumn): void
    {
        $table = $this->sanitizeIdentifier($table);
        $firstColumn = $this->sanitizeIdentifier($firstColumn);
        $secondColumn = $this->sanitizeIdentifier($secondColumn);
        $operator = $this->sanitizeOperator($operator);

        $this->joins[] = "JOIN {$table} ON {$firstColumn} {$operator} {$secondColumn}";
    }

    public function toSql(): string
    {
        return implode(' ', $this->joins);
    }

    private function sanitizeIdentifier(string $identifier): string
    {
        $identifier = str_replace('`', '', $identifier);

        if (! preg_match('/^[a-zA-Z0-9_.]+$/', $identifier)) {
            throw new InvalidArgumentException("Invalid identifier: {$identifier}");
        }

        return $identifier;
    }

    private function sanitizeOperator(string $operator): string
    {
        $allowedOperators = ['=', '!=', '<>', '<', '>', '<=', '>='];

        if (! in_array($operator, $allowedOperators, true)) {
            throw new InvalidArgumentException("Invalid operator: {$operator}");
        }

        return $operator;
    }
}