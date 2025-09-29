<?php
require 'db.php';

$produits = $pdo->query("SELECT IdProduit, NomProduit FROM produit")->fetchAll();
$marches = $pdo->query("SELECT IdMarche, NomMarche FROM marche")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Interface Agent – Relevé des prix</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h3 class="mb-4">📈 Relever les prix par trimestre</h3>
    <form action="traitement_releve.php" method="POST" class="card p-4 shadow">
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
        <label class="form-label">Trimestre</label>
        <select name="trimestre" class="form-select" required>
          <option value="">-- Choisir un trimestre --</option>
          <option value="1">1er trimestre</option>
          <option value="2">2e trimestre</option>
          <option value="3">3e trimestre</option>
          <option value="4">4e trimestre</option>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Prix relevé (en FC)</label>
        <input type="number" step="0.01" name="prix" class="form-control" required>
      </div>

      <button type="submit" class="btn btn-success">📤 Enregistrer le relevé</button>
    </form>

    <hr class="my-5">

    <h4>📊 Télécharger rapport annuel</h4>
    <form action="telecharger_rapport.php" method="POST" class="d-flex gap-3">
      <select name="annee" class="form-select w-25" required>
        <option value="">-- Année --</option>
        <option value="2024">2024</option>
        <option value="2025">2025</option>
      </select>
      <button type="submit" class="btn btn-primary">📥 Télécharger</button>
    </form>
  </div>
</body>
</html>
