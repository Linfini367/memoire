<?php
require 'db.php';

$produits = $pdo->query("SELECT IdProduit, NomProduit FROM produit")->fetchAll();
$marches = $pdo->query("SELECT IdMarche, NomMarche FROM marche")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Relever les prix</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="card shadow">
      <div class="card-header bg-info text-white">
        <h4 class="mb-0">📊 Relever les prix du marché</h4>
      </div>
      <div class="card-body">
        <form action="traitement_releve_mois.php" method="POST">
          <div class="mb-3">
            <label class="form-label">Produit</label>
            <select name="idProduit" class="form-select" required>
              <option value="">-- Choisir un produit --</option>
              <?php foreach ($produits as $p): ?>
                <option value="<?= $p['IdProduit'] ?>"><?= $p['NomProduit'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Marché</label>
            <select name="idMarche" class="form-select" required>
              <option value="">-- Choisir un marché --</option>
              <?php foreach ($marches as $m): ?>
                <option value="<?= $m['IdMarche'] ?>"><?= $m['NomMarche'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Prix relevé</label>
            <input type="number" step="0.01" name="prix" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Date du relevé</label>
            <input type="date" name="dateReleve" class="form-control" value="<?= date('Y-m-d') ?>" required>
          </div>

          <button type="submit" class="btn btn-success">Enregistrer</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
