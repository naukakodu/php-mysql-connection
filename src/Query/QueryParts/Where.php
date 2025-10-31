<?php

namespace Naukakodu\PhpMysqlConnection\Query\QueryParts;

use InvalidArgumentException;
use Naukakodu\PhpMysqlConnection\Query\QueryPart;

class Where extends QueryPart
{
    protected array $conditions = [];
    protected array $bindings = [];

    public function where(string $column, string $operator, mixed $value): void
    {
        $column = $this->sanitizeIdentifier($column);
        $operator = $this->sanitizeOperator($operator);

        $placeholder = ':where_' . count($this->bindings);
        $this->conditions[] = "`{$column}` {$operator} {$placeholder}";
        $this->bindings[$placeholder] = $value;
    }

    public function getBindings(): array
    {
        return $this->bindings;
    }

    public function toSql(): string
    {
        return $this->conditions
            ? 'WHERE ' . implode(' AND ', $this->conditions)
            : '';
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
        $allowedOperators = ['=', '!=', '<>', '<', '>', '<=', '>=', 'LIKE', 'NOT LIKE', 'IN', 'NOT IN'];

        $operator = strtoupper(trim($operator));

        if (! in_array($operator, $allowedOperators, true)) {
            throw new InvalidArgumentException("Invalid operator: {$operator}");
        }

        return $operator;
    }
}
