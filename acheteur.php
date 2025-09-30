<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $idAcheteur = $_POST['idAcheteur'];
  $idProduit = $_POST['idProduit'];

  $stmt = $pdo->prepare("INSERT INTO rapport (IdAcheteur, IdProduit, Periode, Changement) VALUES (?, ?, ?, ?)");
  $stmt->execute([$idAcheteur, $idProduit, date('Y-m'), 'Achat']);

  echo "Achat enregistré.";
}
?>
