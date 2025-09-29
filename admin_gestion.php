<?php
require 'db.php';

$agents = $pdo->query("SELECT IdAgent, NomAgent, EmailAgent FROM agent")->fetchAll();
$vendeurs = $pdo->query("SELECT IdVendeur, NomVendeur, EmailVendeur FROM vendeur")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Gestion des utilisateurs</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h3 class="mb-4">👤 Gestion des agents</h3>
    <table class="table table-bordered">
      <thead class="table-warning">
        <tr>
          <th>Nom</th>
          <th>Email</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($agents as $a): ?>
          <tr>
            <td><?= $a['NomAgent'] ?></td>
            <td><?= $a['EmailAgent'] ?></td>
            <td>
              <form action="admin_action.php" method="POST" class="d-flex gap-2">
                <input type="hidden" name="type" value="agent">
                <input type="hidden" name="id" value="<?= $a['IdAgent'] ?>">
                <button name="action" value="supprimer" class="btn btn-danger btn-sm">Supprimer</button>
                <button name="action" value="bloquer" class="btn btn-secondary btn-sm">Bloquer</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <h3 class="mb-4 mt-5">🛍️ Gestion des vendeurs</h3>
    <table class="table table-bordered">
      <thead class="table-info">
        <tr>
          <th>Nom</th>
          <th>Email</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($vendeurs as $v): ?>
          <tr>
            <td><?= $v['NomVendeur'] ?></td>
            <td><?= $v['EmailVendeur'] ?></td>
            <td>
              <form action="admin_action.php" method="POST" class="d-flex gap-2">
                <input type="hidden" name="type" value="vendeur">
                <input type="hidden" name="id" value="<?= $v['IdVendeur'] ?>">
                <button name="action" value="supprimer" class="btn btn-danger btn-sm">Supprimer</button>
                <button name="action" value="bloquer" class="btn btn-secondary btn-sm">Bloquer</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
