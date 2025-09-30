<?php
require 'db.php';
require 'header.php';

$idVendeur = $_GET['idVendeur'] ?? 0;
$idMarche = $_GET['idMarche'] ?? 0;

// Récupérer le nom du vendeur
$stmt = $pdo->prepare("SELECT NomVendeur FROM vendeur WHERE IdVendeur = ?");
$stmt->execute([$idVendeur]);
$nomVendeur = $stmt->fetchColumn();

// Récupérer le nom du marché
$stmt2 = $pdo->prepare("SELECT NomMarche FROM marche WHERE IdMarche = ?");
$stmt2->execute([$idMarche]);
$nomMarche = $stmt2->fetchColumn();

// Récupérer les produits de ce vendeur dans ce marché
$produits = $pdo->prepare("
  SELECT NomProduit, Description, Prix, DateMaj
  FROM produit
  WHERE IdVendeur = ? AND IdMarche = ?
");
$produits->execute([$idVendeur, $idMarche]);
$listeProduits = $produits->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Produits du vendeur</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h3 class="mb-4">Produits de <span class="text-success"><?= htmlspecialchars($nomVendeur) ?></span> au marché <span class="text-primary"><?= htmlspecialchars($nomMarche) ?></span></h3>
    <table class="table table-bordered table-hover">
      <thead class="table-warning">
        <tr>
          <th>Nom du produit</th>
          <th>Description</th>
          <th>Prix</th>
          <th>Date Maj</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($listeProduits as $p): ?>
          <tr>
            <td><?= htmlspecialchars($p['NomProduit']) ?></td>
            <td><?= htmlspecialchars($p['Description']) ?></td>
            <td><?= htmlspecialchars($p['Prix']) ?></td>
            <td><?= htmlspecialchars($p['DateMaj']) ?></td>
          </tr>
        <?php endforeach; ?>
        <?php if (empty($listeProduits)): ?>
          <tr><td colspan="4" class="text-center text-muted">Aucun produit pour ce vendeur dans ce marché.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
    <a href="marche_vendeurs.php?idMarche=<?= $idMarche ?>" class="btn btn-secondary">Retour aux vendeurs</a>
  </div>
   <?php
  require 'footer.php';
  ?>
</body>
</html>