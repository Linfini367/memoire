<?php
require 'db.php';
require 'header.php';

$idMarche = $_GET['idMarche'] ?? 0;

// Récupérer le nom du marché
$stmt = $pdo->prepare("SELECT NomMarche FROM marche WHERE IdMarche = ?");
$stmt->execute([$idMarche]);
$nomMarche = $stmt->fetchColumn();

// Récupérer les vendeurs de ce marché
$vendeurs = $pdo->prepare("
  SELECT v.IdVendeur, v.NomVendeur
  FROM vendeur v
  JOIN produit p ON v.IdVendeur = p.IdVendeur
  WHERE p.IdMarche = ?
  GROUP BY v.IdVendeur, v.NomVendeur
");
$vendeurs->execute([$idMarche]);
$listeVendeurs = $vendeurs->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Vendeurs du marché</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h3 class="mb-4">Vendeurs du marché <span class="text-primary"><?= htmlspecialchars($nomMarche) ?></span></h3>
    <table class="table table-bordered table-hover">
      <thead class="table-info">
        <tr>
          <th>Nom du vendeur</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($listeVendeurs as $v): ?>
          <tr>
            <td>
              <a href="vendeur_produits.php?idVendeur=<?= $v['IdVendeur'] ?>&idMarche=<?= $idMarche ?>" class="text-success fw-bold">
                <?= htmlspecialchars($v['NomVendeur']) ?>
              </a>
            </td>
            <td>
              <a href="vendeur_produits.php?idVendeur=<?= $v['IdVendeur'] ?>&idMarche=<?= $idMarche ?>" class="btn btn-primary btn-sm">Voir ses produits</a>
            </td>
          </tr>
        <?php endforeach; ?>
        <?php if (empty($listeVendeurs)): ?>
          <tr><td colspan="2" class="text-center text-muted">Aucun vendeur pour ce marché.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
    <a href="admin_marche.php" class="btn btn-secondary">Retour aux marchés</a>
  </div>
   <?php
  require 'footer.php';
  ?>
</body>
</html>