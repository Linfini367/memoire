<?php
session_start();
require 'db.php';

// Récupérer les données du formulaire
$nomAcheteur = $_POST['nomAcheteur'] ?? '';
$postNomAcheteur = $_POST['postNomAcheteur'] ?? '';
$idProduit = $_POST['idProduit'] ?? null;
$prixPropose = $_POST['prixPropose'] ?? null;
$dateDemande = $_POST['dateDemande'] ?? date('Y-m-d');
$vendeur_id = $_SESSION['vendeur_id'] ?? null;

// 1. Vérifier si l'acheteur existe déjà
$stmt = $pdo->prepare("SELECT IdAcheteur FROM acheteur WHERE NomAcheteur = ? AND PostNomAcheteur = ?");
$stmt->execute([$nomAcheteur, $postNomAcheteur]);
$idAcheteur = $stmt->fetchColumn();

if (!$idAcheteur) {
    // Si non, l'ajouter
    $stmt = $pdo->prepare("INSERT INTO acheteur (NomAcheteur, PostNomAcheteur, SexeAcheteur) VALUES (?, ?, ?)");
    $stmt->execute([$nomAcheteur, $postNomAcheteur, 'N']); // 'N' pour non spécifié
    $idAcheteur = $pdo->lastInsertId();
}

// 2. Insérer la demande de commande
$stmt = $pdo->prepare("INSERT INTO demande_commande (IdAcheteur, IdProduit, PrixPropose, DateDemande, Statut) VALUES (?, ?, ?, ?, ?)");
$stmt->execute([$idAcheteur, $idProduit, $prixPropose, $dateDemande, 'En attente']);

// 3. Redirection
header('Location: produits.php?vendeur_id=' . $vendeur_id);
exit;
?>
