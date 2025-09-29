<?php
require 'db.php';

// Produits
$produits = $pdo->query("SELECT IdProduit, NomProduit FROM produit")->fetchAll();

// Marchés
$marches = $pdo->query("SELECT IdMarche, NomMarche FROM marche")->fetchAll();

// Agents
$agents = $pdo->query("SELECT IdAgent, NomAgent FROM agent")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Relever le prix</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="card shadow">
      <div class="card-header bg-warning text-dark">
        <h4 class="mb-0">Relever le prix d’un produit</h4>
      </div>
      <div class="card-body">
        <form action="traitement_releve.php" method="POST">
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
            <label class="form-label">Agent</label>
            <select name="idAgent" class="form-select" required>
              <option value="">-- Choisir un agent --</option>
              <?php foreach ($agents as $a): ?>
                <option value="<?= $a['IdAgent'] ?>"><?= $a['NomAgent'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Valeur du prix</label>
            <input type="number" step="0.01" name="valeur" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Unité</label>
            <input type="text" name="unite" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Date du relevé</label>
            <input type="date" name="dateReleve" class="form-control" value="<?= date('Y-m-d') ?>" required>
          </div>

          <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
