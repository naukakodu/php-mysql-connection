<?php

namespace Naukakodu\PhpMysqlConnection\Query\QueryParts;

use InvalidArgumentException;
use Naukakodu\PhpMysqlConnection\Query\QueryPart;

class Limit extends QueryPart
{
    protected ?int $limit = null;

    public function limit(int $limit): void
    {
        if ($limit < 0) {
            throw new InvalidArgumentException('Limit cannot be negative.');
        }

        $this->limit = $limit;
    }

    public function toSql(): string
    {
        return $this->limit !== null ? "LIMIT {$this->limit}" : '';
    }
}
