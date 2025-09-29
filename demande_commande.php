<?php
require 'db.php';

$produits = $pdo->query("SELECT IdProduit, NomProduit FROM produit")->fetchAll();
$acheteurs = $pdo->query("SELECT IdAcheteur, NomAcheteur, PostNomAcheteur FROM acheteur")->fetchAll();
$marches = $pdo->query("SELECT IdMarche, NomMarche FROM marche")->fetchAll(); // Ajout pour les marchés
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Demande de commande</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="card shadow">
      <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Soumettre une demande de commande</h4>
      </div>
      <div class="card-body">
        <form action="traitement_demande.php" method="POST">
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
            <label class="form-label">Marché</label>
            <select name="idMarche" class="form-select" required>
              <option value="">-- Choisir un marché --</option>
              <?php foreach ($marches as $m): ?>
                <option value="<?= $m['IdMarche'] ?>"><?= $m['NomMarche'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Prix proposé</label>
            <input type="number" step="0.01" name="prixPropose" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Date de la demande</label>
            <input type="date" name="dateDemande" class="form-control" value="<?= date('Y-m-d') ?>" required>
          </div>

          <button type="submit" class="btn btn-success">Soumettre la demande</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
