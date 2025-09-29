<?php
require 'db.php';

$type = $_POST['type'];
$id = $_POST['id'];
$action = $_POST['action'];

if ($type === 'agent') {
  if ($action === 'supprimer') {
    $pdo->prepare("DELETE FROM agent WHERE IdAgent = ?")->execute([$id]);
    echo "✅ Agent supprimé.";
  } elseif ($action === 'bloquer') {
    // Exemple : ajouter une colonne 'Bloque' dans la table agent
    $pdo->prepare("UPDATE agent SET EmailAgent = CONCAT('bloque_', EmailAgent) WHERE IdAgent = ?")->execute([$id]);
    echo "🚫 Agent bloqué.";
  }
}

if ($type === 'vendeur') {
  if ($action === 'supprimer') {
    $pdo->prepare("DELETE FROM vendeur WHERE IdVendeur = ?")->execute([$id]);
    echo "✅ Vendeur supprimé.";
  } elseif ($action === 'bloquer') {
    $pdo->prepare("UPDATE vendeur SET EmailVendeur = CONCAT('bloque_', EmailVendeur) WHERE IdVendeur = ?")->execute([$id]);
    echo "🚫 Vendeur bloqué.";
  }
}
?>
