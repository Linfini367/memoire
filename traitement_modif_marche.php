<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['idMarche'];
  $nom = $_POST['nomMarche'];
  $loc = $_POST['localisation'];
  $agent = $_POST['idAgent'];

  $stmt = $pdo->prepare("UPDATE marche SET NomMarche = ?, Localisation = ?, IdAgent = ? WHERE IdMarche = ?");
  $stmt->execute([$nom, $loc, $agent, $id]);

  echo "<div style='padding:20px;font-family:sans-serif;'>✅ Marché mis à jour avec succès.</div>";
    header("location: admin_marche.php");
    exit();
}   
?>
    