<?php

namespace Naukakodu\PhpMysqlConnection\Query;

abstract class QueryPart
{
    protected QueryBuilder $builder;

    public function __construct(QueryBuilder $builder)
    {
        $this->builder = $builder;
    }

    public function getBindings(): array
    {
        return [];
    }

    abstract public function toSql(): string;
}