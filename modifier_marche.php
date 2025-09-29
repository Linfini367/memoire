<?php
require 'db.php';

if (!isset($_GET['idMarche']) || empty($_GET['idMarche'])) {
    echo "Aucun marché sélectionné.";
    exit();
}

$id = $_GET['idMarche'];
$stmt = $pdo->prepare("SELECT * FROM marche WHERE IdMarche = ?");
$stmt->execute([$id]);
$marche = $stmt->fetch();

if (!$marche) {
    echo "Aucun marché sélectionné.";
    exit();
}

$agents = $pdo->query("SELECT IdAgent, NomAgent FROM agent")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Modifier le marché</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="card shadow">
      <div class="card-header bg-secondary text-white">
        <h4 class="mb-0">✏️ Modifier le marché</h4>
      </div>
      <div class="card-body">
        <form action="traitement_modif_marche.php" method="POST">
          <input type="hidden" name="idMarche" value="<?= $marche['IdMarche'] ?>">

          <div class="mb-3">
            <label class="form-label">Nom du marché</label>
            <input type="text" name="nomMarche" class="form-control" value="<?= $marche['NomMarche'] ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Localisation</label>
            <input type="text" name="localisation" class="form-control" value="<?= $marche['Localisation'] ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Agent responsable</label>
            <select name="idAgent" class="form-select" required>
              <?php foreach ($agents as $a): ?>
                <option value="<?= $a['IdAgent'] ?>" <?= $a['IdAgent'] == $marche['IdAgent'] ? 'selected' : '' ?>>
                  <?= $a['NomAgent'] ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
