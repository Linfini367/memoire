<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $idAgent = $_POST['idAgent'];
  $idProduit = $_POST['idProduit'];
  $valeur = $_POST['valeur'];
  $unite = $_POST['unite'];

  $stmt = $pdo->prepare("INSERT INTO prix (IdProduit, Valeur, Unité) VALUES (?, ?, ?)");
  $stmt->execute([$idProduit, $valeur, $unite]);

  echo "Prix relevé.";
}
?>
