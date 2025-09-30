<?php
require 'db.php';

$idAcheteur = $_GET['idAcheteur'] ?? null;

if ($idAcheteur) {
  $demandes = $pdo->prepare("
    SELECT dc.IdDemande, dc.PrixPropose, dc.DateDemande, dc.Statut,
           p.NomProduit
    FROM demande_commande dc
    JOIN produit p ON dc.IdProduit = p.IdProduit
    WHERE dc.IdAcheteur = ?
    ORDER BY dc.DateDemande DESC
  ");
  $demandes->execute([$idAcheteur]);
  $resultats = $demandes->fetchAll();
} else {
  $resultats = [];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Suivi des demandes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h3 class="mb-4">📋 Suivi de vos demandes de commande</h3>
    <?php if ($resultats): ?>
      <table class="table table-bordered table-hover">
        <thead class="table-info">
          <tr>
            <th>Produit</th>
            <th>Prix proposé</th>
            <th>Date</th>
            <th>Statut</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($resultats as $d): ?>
            <tr>
              <td><?= $d['NomProduit'] ?></td>
              <td><?= number_format($d['PrixPropose'], 2) ?> CDF</td>
              <td><?= $d['DateDemande'] ?></td>
              <td>
                <?php if ($d['Statut'] === 'Validée'): ?>
                  <span class="badge bg-success">Validée</span>
                <?php elseif ($d['Statut'] === 'Rejetée'): ?>
                  <span class="badge bg-danger">Rejetée</span>
                <?php else: ?>
                  <span class="badge bg-warning text-dark">En attente</span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <div class="alert alert-secondary">Aucune demande trouvée pour cet acheteur.</div>
    <?php endif; ?>
  </div>
</body>
</html>
