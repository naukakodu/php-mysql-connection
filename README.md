## Installation via composer

```
composer require php-mysql-connection/database
```

## Features

The library offers a simple `Database` class with the following capabilities:
- Establishing a secure PDO connection with a MySQL database
- Executing SQL queries with prepared statements support
- Retrieving single rows or entire result sets
- Handling data insertion with the ability to retrieve the last inserted ID

## Usage Examples

### Basic Connection

```php
use Naukakodu\PhpMysqlConnection\Database;

try {
    $db = new Database('localhost', 'database_name', 'username', 'password');
    
    // ...
} catch (Exception $e) {
    echo $e->getMessage();
}
```

### Retrieving Data
```php
// Fetching all rows
$users = $db->fetchAll("SELECT * FROM users WHERE status = ?", ['active']);

// Fetching a single row
$user = $db->fetch("SELECT * FROM users WHERE id = ?", [1]);
```

### Inserting Data
```php
$userId = $db->insert(
    "INSERT INTO users (name, email, created_at) VALUES (?, ?, NOW())",
    ['John Smith', 'john@example.com']
);

echo "Added user with ID: " . $userId;
```

### Executing Other Queries
```php
$db->query("UPDATE users SET status = ? WHERE id = ?", ['inactive', 5]);
```

### Accessing the PDO Object
```php
$pdo = $db->getConnection();
// ...
```

### Configuration
The default character set is `utf8mb4`. You can change it during initialization:

```php
$db = new Database('localhost', 'database_name', 'username', 'password', 'utf8');
```