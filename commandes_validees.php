<?php
require 'db.php';

$commandes = $pdo->query("
  SELECT c.IdCommande, c.PrixUnitaire, c.DateCmd,
         p.NomProduit, v.NomVendeur
  FROM commande c
  JOIN produit p ON c.IdProduit = p.IdProduit
  JOIN vendeur v ON p.IdVendeur = v.IdVendeur
  ORDER BY c.DateCmd DESC
")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Commandes validées</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h3 class="mb-4">📦 Commandes validées</h3>
    <table class="table table-bordered table-hover">
      <thead class="table-success">
        <tr>
          <th>ID</th>
          <th>Produit</th>
          <th>Vendeur</th>
          <th>Prix unitaire</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($commandes as $cmd): ?>
          <tr>
            <td><?= $cmd['IdCommande'] ?></td>
            <td><?= $cmd['NomProduit'] ?></td>
            <td><?= $cmd['NomVendeur'] ?></td>
            <td><?= number_format($cmd['PrixUnitaire'], 2) ?> CDF</td>
            <td><?= $cmd['DateCmd'] ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
