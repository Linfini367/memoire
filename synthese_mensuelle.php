<?php
require 'db.php';

$mois = $_POST['mois'] ?? date('Y-m') . '-01';

$releves = $pdo->prepare("
  SELECT p.NomProduit, m.NomMarche, r.Prix
  FROM releve_mensuel r
  JOIN produit p ON r.IdProduit = p.IdProduit
  JOIN marche m ON r.IdMarche = m.IdMarche
  WHERE r.Mois = ?
  ORDER BY p.NomProduit, m.NomMarche
");
$releves->execute([$mois]);
$data = $releves->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Synthèse mensuelle des prix</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h3 class="mb-4">📊 Synthèse des prix – <?= date('F Y', strtotime($mois)) ?></h3>

    <form method="POST" class="mb-4 d-flex gap-3">
      <input type="month" name="mois" class="form-control w-25" value="<?= substr($mois, 0, 7) ?>" required>
      <button type="submit" class="btn btn-primary">🔍 Voir le rapport</button>
    </form>

    <?php if ($data): ?>
      <table class="table table-bordered table-hover">
        <thead class="table-info">
          <tr>
            <th>Produit</th>
            <th>Marché</th>
            <th>Prix relevé (FC)</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($data as $row): ?>
            <tr>
              <td><?= $row['NomProduit'] ?></td>
              <td><?= $row['NomMarche'] ?></td>
              <td><?= number_format($row['Prix'], 2) ?></td>
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
