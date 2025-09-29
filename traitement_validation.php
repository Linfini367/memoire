<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $idDemande = $_POST['idDemande'];
  $action = $_POST['action'];

  if ($action === 'valider') {
    // Récupérer les infos de la demande
    $demande = $pdo->prepare("SELECT IdProduit, PrixPropose, DateDemande FROM demande_commande WHERE IdDemande = ?");
    $demande->execute([$idDemande]);
    $data = $demande->fetch();

    // Insérer dans commande
    $stmt = $pdo->prepare("INSERT INTO commande (IdProduit, PrixUnitaire, DateCmd)
                           VALUES (?, ?, ?)");
    $stmt->execute([$data['IdProduit'], $data['PrixPropose'], $data['DateDemande']]);

    // Mettre à jour le statut
    $pdo->prepare("UPDATE demande_commande SET Statut = 'Validée' WHERE IdDemande = ?")->execute([$idDemande]);

    echo "<div style='padding:20px;font-family:sans-serif;'>✅ Commande validée et enregistrée.</div>";
    header("location: valider_demande.php");
  } elseif ($action === 'rejeter') {
    $pdo->prepare("UPDATE demande_commande SET Statut = 'Rejetée' WHERE IdDemande = ?")->execute([$idDemande]);
    echo "<div style='padding:20px;font-family:sans-serif;color:red;'>❌ Commande rejetée.</div>";
    header("location: valider_demande.php");
  }
}
?>
