<?php
require 'db.php';
require_once 'header.php';
// Récupérer les mois choisis (format YYYY-MM)
$mois1 = isset($_POST['mois1']) ? $_POST['mois1'] . '-01' : date('Y-m-01');
$mois2 = isset($_POST['mois2']) ? $_POST['mois2'] . '-01' : date('Y-m-01');

// Récupérer le marché sélectionné
$marcheFiltre = isset($_POST['marcheFiltre']) ? $_POST['marcheFiltre'] : '';

// Requête pour récupérer tous les produits
$produits = $pdo->query("SELECT IdProduit, NomProduit FROM produit")->fetchAll();

// Récupérer tous les marchés pour la liste déroulante
$allMarches = $pdo->query("SELECT IdMarche, NomMarche FROM marche")->fetchAll();

// Préparer la liste des marchés à afficher
if ($marcheFiltre && $marcheFiltre != 'all') {
    $marches = $pdo->prepare("SELECT IdMarche, NomMarche FROM marche WHERE IdMarche = ?");
    $marches->execute([$marcheFiltre]);
    $marches = $marches->fetchAll();
} else {
    $marches = $allMarches;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Variation des prix</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="Index.css" rel="stylesheet">
  <style>
    @media print {
      form, .btn, header, .hero-content, footer {
        display: none !important;
      }
      .container {
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
      }
      body {
        background: #fff !important;
      }
    }
  </style>
</head>
<body class="bg-light">
<div class="container mt-5">
  <h3 class="mb-4">📈 Tableau de variation des prix</h3>
  <form method="POST" class="mb-4 row g-3 align-items-end">
    <div class="col-auto">
      <label class="form-label">Mois 1</label>
      <input type="month" name="mois1" class="form-control" value="<?= substr($mois1,0,7) ?>" required>
    </div>
    <div class="col-auto">
      <label class="form-label">Mois 2</label>
      <input type="month" name="mois2" class="form-control" value="<?= substr($mois2,0,7) ?>" required>
    </div>
    <div class="col-auto">
      <label class="form-label">Marché</label>
      <select name="marcheFiltre" class="form-select">
        <option value="all">Tous les marchés</option>
        <?php foreach ($allMarches as $m): ?>
          <option value="<?= $m['IdMarche'] ?>" <?= ($marcheFiltre == $m['IdMarche']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($m['NomMarche']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-auto">
      <button type="submit" class="btn btn-primary">Afficher la variation</button>
    </div>
  </form>

  <div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
      <thead class="table-primary">
        <tr>
          <th>N°</th>
          <th>Produit</th>
          <th>Unité</th>
          <th><?= date('F Y', strtotime($mois1)) ?></th>
          <th><?= date('F Y', strtotime($mois2)) ?></th>
          <th>Variation Absolue</th>
          <th>Variation Relative (%)</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $i = 1;
        foreach ($marches as $marche) {
          echo '<tr class="table-secondary"><td colspan="7"><b>Marché : ' . htmlspecialchars($marche['NomMarche']) . '</b></td></tr>';
          foreach ($produits as $prod) {
            // Récupérer l'unité du produit (depuis la table prix ou produit selon ton modèle)
            $unite = $pdo->prepare("SELECT Unite FROM prix WHERE IdProduit = ? AND IdMarche = ? ORDER BY DateReleve DESC LIMIT 1");
            $unite->execute([$prod['IdProduit'], $marche['IdMarche']]);
            $unite = $unite->fetchColumn();

            // Prix du mois 1
            $stmt1 = $pdo->prepare("SELECT Prix FROM releve_mensuel WHERE IdProduit = ? AND IdMarche = ? AND Mois = ?");
            $stmt1->execute([$prod['IdProduit'], $marche['IdMarche'], $mois1]);
            $prix1 = $stmt1->fetchColumn();
            if ($prix1 === false) $prix1 = 0;

            // Prix du mois 2
            $stmt2 = $pdo->prepare("SELECT Prix FROM releve_mensuel WHERE IdProduit = ? AND IdMarche = ? AND Mois = ?");
            $stmt2->execute([$prod['IdProduit'], $marche['IdMarche'], $mois2]);
            $prix2 = $stmt2->fetchColumn();
            if ($prix2 === false) $prix2 = 0;

            // Calcul variation
            $variationAbs = $prix2 - $prix1;
            $variationRel = ($prix1 != 0) ? round(($variationAbs / $prix1) * 100, 2) : 0;

            echo "<tr>
              <td>{$i}</td>
              <td>{$prod['NomProduit']}</td>
              <td>{$unite}</td>
              <td>".number_format($prix1, 0, ',', ' ')."</td>
              <td>".number_format($prix2, 0, ',', ' ')."</td>
              <td>".number_format($variationAbs, 0, ',', ' ')."</td>
              <td>".number_format($variationRel, 2, ',', ' ')."</td>
            </tr>";
            $i++;
          }
        }
        ?>
      </tbody>
    </table>
  </div>
<?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'agent'): ?>
  <div class="row mt-5">
    <div class="col-md-6">
      <h5>Marché Nyawera (Secteur)</h5>
      <canvas id="pieNyawera"></canvas>
    </div>
    <div class="col-md-6">
      <h5>Marché Kadutu (Histogramme)</h5>
      <canvas id="barKadutu"></canvas>
    </div>
  </div>
  <div class="mt-4 text-end">
    <button class="btn btn-success" onclick="window.print()">Imprimer les statistiques</button>
    <a href="export_variation_pdf.php?mois1=<?= substr($mois1,0,7) ?>&mois2=<?= substr($mois2,0,7) ?>&marcheFiltre=<?= $marcheFiltre ?>" class="btn btn-danger" target="_blank">Exporter PDF</a>
  </div>
  <?php
    // Récupérer les données pour Nyawera et Kadutu
    $nyaweraId = null;
    $kadutuId = null;
    foreach ($allMarches as $m) {
      if (stripos($m['NomMarche'], 'nyawera') !== false) $nyaweraId = $m['IdMarche'];
      if (stripos($m['NomMarche'], 'kadutu') !== false) $kadutuId = $m['IdMarche'];
    }
    // Produits et prix pour Nyawera
    $nyaweraData = [];
    if ($nyaweraId) {
      foreach ($produits as $prod) {
        $stmt = $pdo->prepare("SELECT Prix FROM releve_mensuel WHERE IdProduit = ? AND IdMarche = ? AND Mois = ?");
        $stmt->execute([$prod['IdProduit'], $nyaweraId, $mois2]);
        $prix = $stmt->fetchColumn();
        $nyaweraData[] = [
          'label' => $prod['NomProduit'],
          'value' => $prix ? floatval($prix) : 0
        ];
      }
    }
    // Produits et prix pour Kadutu
    $kadutuLabels = [];
    $kadutuValues = [];
    if ($kadutuId) {
      foreach ($produits as $prod) {
        $stmt = $pdo->prepare("SELECT Prix FROM releve_mensuel WHERE IdProduit = ? AND IdMarche = ? AND Mois = ?");
        $stmt->execute([$prod['IdProduit'], $kadutuId, $mois2]);
        $prix = $stmt->fetchColumn();
        $kadutuLabels[] = $prod['NomProduit'];
        $kadutuValues[] = $prix ? floatval($prix) : 0;
      }
    }
  ?>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    // Pie chart Nyawera
    const pieNyawera = document.getElementById('pieNyawera').getContext('2d');
    new Chart(pieNyawera, {
      type: 'pie',
      data: {
        labels: <?= json_encode(array_column($nyaweraData, 'label')) ?>,
        datasets: [{
          data: <?= json_encode(array_column($nyaweraData, 'value')) ?>,
          backgroundColor: [
            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'
          ]
        }]
      }
    });
    // Bar chart Kadutu
    const barKadutu = document.getElementById('barKadutu').getContext('2d');
    new Chart(barKadutu, {
      type: 'bar',
      data: {
        labels: <?= json_encode($kadutuLabels) ?>,
        datasets: [{
          label: 'Prix',
          data: <?= json_encode($kadutuValues) ?>,
          backgroundColor: '#36A2EB'
        }]
      },
      options: {
        scales: {
          y: { beginAtZero: true }
        }
      }
    });
  </script>
<?php endif; ?>
</div>
 <?php
  require 'footer.php';
  ?>
</body>
</html>

