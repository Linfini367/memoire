<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $idAcheteur = $_POST['idAcheteur'];
  $idProduit = $_POST['idProduit'];
  $idMarche = $_POST['idMarche']; // Ajouté
  $prixPropose = $_POST['prixPropose'];
  $dateDemande = $_POST['dateDemande'];

  $stmt = $pdo->prepare("INSERT INTO demande_commande (IdAcheteur, IdProduit, IdMarche, PrixPropose, DateDemande, Statut)
                         VALUES (?, ?, ?, ?, ?, 'En attente')");
  $stmt->execute([$idAcheteur, $idProduit, $idMarche, $prixPropose, $dateDemande]);

  echo "<div style='padding:20px;font-family:sans-serif;'>✅ Demande enregistrée. En attente de validation par le vendeur.</div>";
  header("location: demande_commande.php");
  exit();
}
?>
