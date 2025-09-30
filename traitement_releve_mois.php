<?php
require 'db.php';

$idProduit = $_POST['idProduit'];
$idMarche = $_POST['idMarche'];
$mois = $_POST['mois']; // Format YYYY-MM
$prix = $_POST['prix']; // Prix saisi par l'agent

$debutMois = $mois . '-01';

// Enregistrer le relevé mensuel avec le prix saisi
$stmt = $pdo->prepare("INSERT INTO releve_mensuel (IdProduit, IdMarche, Mois, Prix)
                       VALUES (?, ?, ?, ?)");
$stmt->execute([$idProduit, $idMarche, $debutMois, $prix]);
header("location: agent_releve_mensuel.php");
exit();
?>