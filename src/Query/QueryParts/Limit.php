<?php

namespace Naukakodu\PhpMysqlConnection\Query\QueryParts;

use Naukakodu\PhpMysqlConnection\Query\QueryPart;

class Limit extends QueryPart
{
    protected ?int $limit = null;

    public function limit(int $limit): void
    {
        $this->limit = $limit;
    }

    public function toSql(): string
    {
        return $this->limit !== null ? "LIMIT {$this->limit}" : '';
    }
}
