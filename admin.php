<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nom = $_POST['nom'];
  $email = $_POST['email'];
  $tel = $_POST['tel'];

  $stmt = $pdo->prepare("INSERT INTO agent (NomAgent, EmailAgent, TelAgent) VALUES (?, ?, ?)");
  $stmt->execute([$nom, $email, $tel]);

  echo "Agent ajouté avec succès.";
}
?>
