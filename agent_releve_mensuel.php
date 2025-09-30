<?php
require 'db.php';

$produits = $pdo->query("SELECT IdProduit, NomProduit FROM produit")->fetchAll();
$marches = $pdo->query("SELECT IdMarche, NomMarche FROM marche")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Relevé mensuel des prix</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h3 class="mb-4">📅 Relever les prix mensuels</h3>
    <form action="traitement_releve_mois.php" method="POST" class="card p-4 shadow">
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
        <label class="form-label">Mois</label>
        <input type="month" name="mois" class="form-control" value="<?= date('Y-m') ?>" required>
      </div>

      <button type="submit" class="btn btn-success">📤 Enregistrer</button>
    </form>

    <hr class="my-5">

    <h4>📊 Télécharger rapport mensuel</h4>
    <form action="telecharger_rapport_mensuel.php" method="POST" class="d-flex gap-3">
      <input type="month" name="mois" class="form-control w-25" required>
      <button type="submit" class="btn btn-primary">📥 Télécharger</button>
    </form>
  </div>
</body>
</html>
