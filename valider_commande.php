<?php
require 'db.php';

// Exemple : commandes en attente simulées
$commandesEnAttente = $pdo->query("
  SELECT p.IdProduit, p.NomProduit, a.IdAcheteur, a.NomAcheteur, a.PostNomAcheteur
  FROM produit p
  JOIN acheteur a ON a.IdAcheteur = 1 -- à adapter selon ton système
  LIMIT 5
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
              <form action="traitement_validation.php" method="POST" class="d-flex gap-2">
                <input type="hidden" name="idProduit" value="<?= $cmd['IdProduit'] ?>">
                <input type="hidden" name="prixUnitaire" value="2500"> <!-- à adapter -->
                <input type="hidden" name="dateCmd" value="<?= date('Y-m-d') ?>">
                <button type="submit" name="action" value="valider" class="btn btn-success btn-sm">Valider</button>
                <button type="submit" name="action" value="rejeter" class="btn btn-danger btn-sm">Rejeter</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
