<?php

use Naukakodu\PhpMysqlConnection\Database;

beforeAll(function () {
    setupPestDatabase();
});

/**
 * Before running this test, make sure that you have a database named "pest"
 * on your local machine.
 */
it('returns pdo instance', function () {
    $database = new Database('localhost', 'pest', 'root', 'root');
    $pdoInstance = $database->getConnection();

    expect($pdoInstance)->toBeInstanceOf(PDO::class);
});