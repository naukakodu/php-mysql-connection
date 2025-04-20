## Instalacja przez composer

```
composer require php-mysql-connection/database
```

## Funkcje

Biblioteka oferuje prostą klasę `Database` z następującymi możliwościami:
- Ustanawianie bezpiecznego połączenia PDO z bazą danych MySQL
- Wykonywanie zapytań SQL z obsługą prepared statements
- Pobieranie pojedynczych wierszy lub całych zestawów wyników
- Obsługa wstawiania danych z możliwością pobrania ostatniego ID

## Przykłady użycia

### Podstawowe połączenie

```php
use Naukakodu\PhpMysqlConnection\Database;

try {
    $db = new Database('localhost', 'nazwa_bazy', 'uzytkownik', 'haslo');
    
    // ...
} catch (Exception $e) {
    echo $e->getMessage();
}
```

### Pobieranie danych
```php
// Pobieranie wszystkich wierszy
$users = $db->fetchAll("SELECT * FROM users WHERE status = ?", ['active']);

// Pobieranie pojedynczego wiersza
$user = $db->fetch("SELECT * FROM users WHERE id = ?", [1]);
```

### Wstawianie danych
```php
$userId = $db->insert(
    "INSERT INTO users (name, email, created_at) VALUES (?, ?, NOW())",
    ['Jan Kowalski', 'jan@example.com']
);

echo "Dodano użytkownika z ID: " . $userId;
```

### Wykonywanie innych zapytań
```php
$db->query("UPDATE users SET status = ? WHERE id = ?", ['inactive', 5]);
```

### Dostęp do obiektu PDO
```php
$pdo = $db->getConnection();
// ...
```

### Konfiguracja
Domyślnym zestawem znaków jest `utf8mb4`. Możesz go zmienić podczas inicjalizacji:

```php
$db = new Database('localhost', 'nazwa_bazy', 'uzytkownik', 'haslo', 'utf8');
```