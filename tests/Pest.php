<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind a different classes or traits.
|
*/

use Naukakodu\PhpMysqlConnection\Database;

pest()->extend(Naukakodu\Tests\TestCase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function setupPestDatabase(): void
{
    $database = new Database('localhost', 'pest', 'root', 'root');
    $database->query('CREATE TABLE IF NOT EXISTS users (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(255))')->execute();
    $database->query('TRUNCATE TABLE users')->execute();
    $database->query('INSERT INTO users (name) VALUES (?), (?), (?), (?), (?), (?), (?), (?), (?), (?), (?), (?)', ['John', 'Jane', 'Jeremy', 'Jacob', 'Elizabeth', 'Mabel', 'Dorothy', 'Paul', 'Agness', 'Alice', 'Mark', 'Steve']);
}
