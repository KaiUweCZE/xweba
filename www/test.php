<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Test PHP a MySQL</h1>";

// Test PHP
echo "<p>PHP běží v pořádku!</p>";

// Test MySQL pomocí PDO
try {
    $dsn = "mysql:host=db;dbname=mojedatabaze;charset=utf8mb4";
    $username = "uzivatel";
    $password = "heslo";
    
    $db = new PDO($dsn, $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p style='color: green;'>Připojení k MySQL je funkční!</p>";
} catch (PDOException $e) {
    echo "<p style='color: red;'>Chyba připojení k MySQL: " . $e->getMessage() . "</p>";
}
?>
