<?php

namespace Naukakodu\PhpMysqlConnection\Query\QueryParts;

use Naukakodu\PhpMysqlConnection\Query\QueryPart;

class OrderBy extends QueryPart
{
    protected array $orders = [];

    public function orderBy(string $column, string $direction = 'asc'): void
    {
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
}