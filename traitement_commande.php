<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $idAcheteur = $_POST['idAcheteur'];
  $idProduit = $_POST['idProduit'];
  $periode = $_POST['periode'];

  // Génération du contenu du rapport
  $tableau = "Commande du produit ID $idProduit par acheteur ID $idAcheteur";
  $diagramme = "Variation non disponible";

  // Récupérer l'agent lié à l'acheteur (si relation ajoutée)
  $agent = $pdo->query("SELECT IdAgent FROM acheteur WHERE IdAcheteur = $idAcheteur")->fetch();
  $idAgent = $agent['IdAgent'] ?? null;

  if ($idAgent) {
    $stmt = $pdo->prepare("INSERT INTO rapport (Periode, TableauVariation, DiagrammeVariation, IdAgent)
                           VALUES (?, ?, ?, ?)");
    $stmt->execute([$periode, $tableau, $diagramme, $idAgent]);

    echo "<div style='padding:20px;font-family:sans-serif;'>✅ Commande enregistrée et rapport généré.</div>";
  } else {
    echo "<div style='color:red;padding:20px;'>❌ Agent introuvable pour cet acheteur.</div>";
  }
}
?>
