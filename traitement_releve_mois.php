<?php
require 'db.php';

$idProduit = $_POST['idProduit'];
$idMarche = $_POST['idMarche'];
$mois = $_POST['mois']; // Format YYYY-MM

// Calculer la période du mois
$debutMois = $mois . '-01';
$finMois = date('Y-m-t', strtotime($debutMois)); // Dernier jour du mois

// Récupérer le total des prix du produit vendu sur ce marché pendant le mois
$stmt = $pdo->prepare("
    SELECT SUM(PrixUnitaire) AS total_prix
    FROM commande
    WHERE IdProduit = ? 
      AND IdMarche = ?
      AND DateCmd BETWEEN ? AND ?
");
$stmt->execute([$idProduit, $idMarche, $debutMois, $finMois]);
$total = $stmt->fetchColumn();
if ($total === null) $total = 0;

// Enregistrer le relevé mensuel
$stmt = $pdo->prepare("INSERT INTO releve_mensuel (IdProduit, IdMarche, Mois, Prix)
                       VALUES (?, ?, ?, ?)");
$stmt->execute([$idProduit, $idMarche, $debutMois, $total]);
header("location: agent_releve_mensuel.php");
exit();
?>