<?php

namespace Naukakodu\PhpMysqlConnection\Query\QueryParts;

use InvalidArgumentException;
use Naukakodu\PhpMysqlConnection\Query\QueryPart;

class OrderBy extends QueryPart
{
    protected array $orders = [];

    public function orderBy(string $column, string $direction = 'asc'): void
    {
        $column = $this->sanitizeIdentifier($column);
        $direction = $this->sanitizeDirection($direction);

        $this->orders[] = [$column, $direction];
    }

    public function toSql(): string
    {
        return $this->orders
            ? 'ORDER BY ' . implode(', ', array_map(function ($order) {
                return $order[0] . ' ' . $order[1];
            }, $this->orders))
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

    private function sanitizeDirection(string $direction): string
    {
        $direction = strtoupper(trim($direction));

        if (! in_array($direction, ['ASC', 'DESC'], true)) {
            throw new InvalidArgumentException("Invalid sorting direction: {$direction}");
        }

        return $direction;
    }
}