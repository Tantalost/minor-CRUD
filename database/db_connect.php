<?php
/*John Loyd Climaco
  Rafsan Unaid
  Justin james Alviar
*/
$host = 'localhost';
$dbname = 'crud';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?> 