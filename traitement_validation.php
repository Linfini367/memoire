<?php
require 'db.php';

$idDemande = $_GET['idDemande'] ?? null;
$action = $_GET['action'] ?? null;

if (!$idDemande || !$action) {
  echo "<div style='padding:20px;font-family:sans-serif;color:red;'>Erreur : données manquantes.</div>";
  exit;
}

if ($action === 'valider') {
  $demande = $pdo->prepare("SELECT IdProduit, PrixPropose, DateDemande FROM demande_commande WHERE IdDemande = ?");
  $demande->execute([$idDemande]);
  $data = $demande->fetch();

  if (!$data) {
    echo "<div style='padding:20px;font-family:sans-serif;color:red;'>Erreur : demande introuvable.</div>";
    exit;
  }

  $stmt = $pdo->prepare("INSERT INTO commande (IdProduit, PrixUnitaire, DateCmd) VALUES (?, ?, ?)");
  $stmt->execute([$data['IdProduit'], $data['PrixPropose'], $data['DateDemande']]);
  $pdo->prepare("UPDATE demande_commande SET Statut = 'Validée' WHERE IdDemande = ?")->execute([$idDemande]);
  header("Location: valider_commande.php");
  exit;
} elseif ($action === 'rejeter') {
  $pdo->prepare("UPDATE demande_commande SET Statut = 'Rejetée' WHERE IdDemande = ?")->execute([$idDemande]);
  header("Location: valider_commande.php");
  exit;
}
?>
