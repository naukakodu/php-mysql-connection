<?php

use Naukakodu\PhpMysqlConnection\Database;

beforeAll(function () {
    setupPestDatabase();
});

it('limits records through limit query part', function () {
    $database = new Database('localhost', 'pest', 'root', 'root');
    $queryBuilder = $database->getQueryBuilder();
    $limitedRowsSql = $queryBuilder->table('users')->limit(5)->toSql();
    $limitedRows = $database->query($limitedRowsSql)->fetchAll();

    expect($limitedRows)->toHaveCount(5);
});