<?php
require 'db.php';

$action = $_POST['action'];

if ($action === 'ajouter') {
  $nom = $_POST['nomMarche'];
  $loc = $_POST['localisation'];
  $agent = $_POST['idAgent'];

  $pdo->prepare("INSERT INTO marche (NomMarche, Localisation, IdAgent)
                 VALUES (?, ?, ?)")->execute([$nom, $loc, $agent]);

  echo "✅ Marché ajouté.";
    header("location: admin_marche.php");
}

if ($action === 'supprimer') {
  $id = $_POST['idMarche'];
  $pdo->prepare("DELETE FROM marche WHERE IdMarche = ?")->execute([$id]);
  echo "🗑️ Marché supprimé.";
    header("location: admin_marche.php");
}

if ($action === 'modifier') {
  $id = $_POST['idMarche'];
  header("Location: modifier_marche.php?idMarche=$id");
  exit();
}
