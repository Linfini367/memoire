<?php
require 'db.php';

// Récupération des commandes en attente
$commandesEnAttente = $pdo->query("
  SELECT d.IdDemande, p.NomProduit, a.NomAcheteur, a.PostNomAcheteur
  FROM demande_commande d
  JOIN produit p ON d.IdProduit = p.IdProduit
  JOIN acheteur a ON d.IdAcheteur = a.IdAcheteur
  WHERE d.Statut = 'En attente'
")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Validation des commandes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h3 class="mb-4">Commandes en attente de validation</h3>
    <table class="table table-bordered table-hover">
      <thead class="table-dark">
        <tr>
          <th>Produit</th>
          <th>Acheteur</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($commandesEnAttente as $cmd): ?>
          <tr>
            <td><?= $cmd['NomProduit'] ?></td>
            <td><?= $cmd['NomAcheteur'] . ' ' . $cmd['PostNomAcheteur'] ?></td>
            <td>
              <a href="traitement_validation.php?idDemande=<?= $cmd['IdDemande'] ?>&action=valider" class="btn btn-success btn-sm">Valider</a>
              <a href="traitement_validation.php?idDemande=<?= $cmd['IdDemande'] ?>&action=rejeter" class="btn btn-danger btn-sm">Rejeter</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
