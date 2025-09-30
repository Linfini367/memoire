<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $mois = $_POST['mois'] . '-01'; // Format YYYY-MM-01

  $releves = $pdo->prepare("
    SELECT p.NomProduit, m.NomMarche, r.Prix
    FROM releve_mensuel r
    JOIN produit p ON r.IdProduit = p.IdProduit
    JOIN marche m ON r.IdMarche = m.IdMarche
    WHERE r.Mois = ?
    ORDER BY p.NomProduit, m.NomMarche
  ");
  $releves->execute([$mois]);
  $resultats = $releves->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Rapport mensuel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h3 class="mb-4">🗓️ Rapport mensuel – <?= date('F Y', strtotime($mois)) ?></h3>

    <?php if ($resultats): ?>
      <table class="table table-bordered table-hover">
        <thead class="table-primary">
          <tr>
            <th>Produit</th>
            <th>Marché</th>
            <th>Prix relevé (FC)</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($resultats as $r): ?>
            <tr>
              <td><?= $r['NomProduit'] ?></td>
              <td><?= $r['NomMarche'] ?></td>
              <td><?= number_format($r['Prix'], 2) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <div class="alert alert-warning">Aucun relevé trouvé pour ce mois.</div>
    <?php endif; ?>
  </div>
</body>
</html>
