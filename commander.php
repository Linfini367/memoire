<?php
require 'db.php';

// Produits disponibles
$produits = $pdo->query("SELECT IdProduit, NomProduit FROM produit")->fetchAll();

// Acheteurs
$acheteurs = $pdo->query("SELECT IdAcheteur, NomAcheteur, PostNomAcheteur FROM acheteur")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Commander une marchandise</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="card shadow">
      <div class="card-header bg-success text-white">
        <h4 class="mb-0">Commander une marchandise</h4>
      </div>
      <div class="card-body">
        <form action="traitement_commande.php" method="POST">
          <div class="mb-3">
            <label class="form-label">Acheteur</label>
            <select name="idAcheteur" class="form-select" required>
              <option value="">-- Choisir un acheteur --</option>
              <?php foreach ($acheteurs as $a): ?>
                <option value="<?= $a['IdAcheteur'] ?>">
                  <?= $a['NomAcheteur'] . ' ' . $a['PostNomAcheteur'] ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Marchandise</label>
            <select name="idProduit" class="form-select" required>
              <option value="">-- Choisir une marchandise --</option>
              <?php foreach ($produits as $p): ?>
                <option value="<?= $p['IdProduit'] ?>"><?= $p['NomProduit'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Période</label>
            <input type="month" name="periode" class="form-control" value="<?= date('Y-m') ?>" required>
          </div>

          <button type="submit" class="btn btn-primary">Commander</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
