<?php
require 'db.php';
require 'header.php';

$marches = $pdo->query("
  SELECT m.IdMarche, m.NomMarche, m.Localisation, a.NomAgent
  FROM marche m
  LEFT JOIN agent a ON m.IdAgent = a.IdAgent
")->fetchAll();

$agents = $pdo->query("SELECT IdAgent, NomAgent FROM agent")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Gestion des marchés</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h3 class="mb-4">🏪 Gestion des marchés</h3>

    <!-- Formulaire d'ajout -->
    <div class="card mb-4">
      <div class="card-header bg-success text-white">Ajouter un marché</div>
      <div class="card-body">
        <form action="traitement_marche.php" method="POST">
          <input type="hidden" name="action" value="ajouter">
          <div class="mb-3">
            <label class="form-label">Nom du marché</label>
            <input type="text" name="nomMarche" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Localisation</label>
            <input type="text" name="localisation" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Agent responsable</label>
            <select name="idAgent" class="form-select" required>
              <option value="">-- Choisir un agent --</option>
              <?php foreach ($agents as $a): ?>
                <option value="<?= $a['IdAgent'] ?>"><?= $a['NomAgent'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
      </div>
    </div>

    <!-- Liste des marchés -->
    <table class="table table-bordered table-hover">
      <thead class="table-warning">
        <tr>
          <th>Nom</th>
          <th>Localisation</th>
          <th>Agent</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($marches as $m): ?>
          <tr>
            <td>
              <a href="marche_vendeurs.php?idMarche=<?= $m['IdMarche'] ?>" class="text-primary fw-bold">
                <?= htmlspecialchars($m['NomMarche']) ?>
              </a>
            </td>
            <td><?= $m['Localisation'] ?></td>
            <td><?= $m['NomAgent'] ?? 'Non assigné' ?></td>
            <td>
              <form action="traitement_marche.php" method="POST" class="d-flex gap-2">
                <input type="hidden" name="idMarche" value="<?= $m['IdMarche'] ?>">
                <button name="action" value="supprimer" class="btn btn-danger btn-sm">Supprimer</button>
                <a href="modifier_marche.php?idMarche=<?= $m['IdMarche'] ?>" class="btn btn-secondary btn-sm">Modifier</a>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php
  require 'footer.php';
  ?>
</body>
</html>
