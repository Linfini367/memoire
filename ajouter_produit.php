<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nom = $_POST['nom'];
  $description = $_POST['description'];
  $prix = $_POST['prix'];
  $dateAjout = $_POST['dateAjout'];
  $idVendeur = $_POST['idVendeur'];
  $idMarche = $_POST['idMarche'];

  $stmt = $pdo->prepare("INSERT INTO produit (NomProduit, Description, Prix, DateAjout, IdVendeur, IdMarche)
                         VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->execute([$nom, $description, $prix, $dateAjout, $idVendeur, $idMarche]);

  echo "✅ Produit ajouté avec succès.";
}
?>
