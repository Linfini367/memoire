<?php
$host = 'localhost';
$dbname = 'marche_db';
$user = 'root';
$pass = '';

try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
} catch (PDOException $e) {
  die("Erreur de connexion : " . $e->getMessage());
}
?>
