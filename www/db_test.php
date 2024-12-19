<?php
// Připojovací údaje k databázi
$host = 'db';  // Používáme název služby z docker-compose
$db   = 'mojedatabaze';
$user = 'uzivatel';
$pass = 'heslo';

try {
    // Pokus o připojení k databázi
    $pdo = new PDO(
        "mysql:host=$host;dbname=$db",
        $user,
        $pass,
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
    );
    echo "Úspěšně připojeno k databázi MySQL!";
    
    // Základní test - vytvoření tabulky
    $pdo->exec("CREATE TABLE IF NOT EXISTS test (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50)
    )");
    echo "<br>Testovací tabulka vytvořena úspěšně.";
    
} catch(PDOException $e) {
    echo "Chyba připojení: " . $e->getMessage();
}
?>