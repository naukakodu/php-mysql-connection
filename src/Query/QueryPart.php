<?php

namespace Naukakodu\PhpMysqlConnection\Query;

abstract class QueryPart
{
    protected QueryBuilder $builder;

    public function __construct(QueryBuilder $builder)
    {
        $this->builder = $builder;
    }

    abstract public function toSql(): string;
}