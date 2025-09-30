<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}
require_once 'header.php';
require 'db.php';

// Statistiques simples
$totalAgents = $pdo->query("SELECT COUNT(*) FROM agent")->fetchColumn();
$totalMarches = $pdo->query("SELECT COUNT(*) FROM marche")->fetchColumn();
$totalVendeurs = $pdo->query("SELECT COUNT(*) FROM vendeur")->fetchColumn();
$totalProduits = $pdo->query("SELECT COUNT(*) FROM produit")->fetchColumn();
$totalCommandes = $pdo->query("SELECT COUNT(*) FROM commande")->fetchColumn();

// Préparer les données pour le graphique : commandes par mois (12 derniers mois)
$labels = [];
$data = [];
for ($i = 11; $i >= 0; $i--) {
    $mois = date('Y-m', strtotime("-$i months"));
    $labels[] = date('M Y', strtotime($mois . '-01'));
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM commande WHERE DATE_FORMAT(DateCmd, '%Y-%m') = ?");
    $stmt->execute([$mois]);
    $data[] = (int)$stmt->fetchColumn();
}

// Préparer les données pour le graphique : prix moyen par mois (12 derniers mois) pour un produit donné
$idProduit = 1; // Choisis l'ID du produit à afficher
$labelsPrix = [];
$dataPrix = [];
for ($i = 11; $i >= 0; $i--) {
    $mois = date('Y-m', strtotime("-$i months"));
    $labelsPrix[] = date('M Y', strtotime($mois . '-01'));
    $stmt = $pdo->prepare("SELECT AVG(Prix) FROM releve_mensuel WHERE IdProduit = ? AND DATE_FORMAT(Mois, '%Y-%m') = ?");
    $stmt->execute([$idProduit, $mois]);
    $dataPrix[] = round((float)$stmt->fetchColumn(), 2);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="index.css">
  <!-- Ajoute ce style dans le <head> -->
</head>
<body>
<div class="container mt-5 mb-5">
  <div class="card shadow mb-4">
    <div class="card-header bg-primary text-white">
      <h2 class="mb-0 text-center">Bienvenue Admin</h2>
    </div>
    <!-- statistiques -->
    <div class="card-body">
      <div class="row g-4 mb-4 justify-content-center">
        <div class="col-md-2 col-6">
          <div class="card text-center border-primary card-hover h-100">
            <div class="card-body">
              <h6 class="card-title text-primary">Agents</h6>
              <p class="display-6"><?= $totalAgents ?></p>
            </div>
          </div>
        </div>
        <div class="col-md-2 col-6">
          <div class="card text-center border-success card-hover h-100">
            <div class="card-body">
              <h6 class="card-title text-success">Marchés</h6>
              <p class="display-6"><?= $totalMarches ?></p>
            </div>
          </div>
        </div>
        <div class="col-md-2 col-6">
          <div class="card text-center border-warning card-hover h-100">
            <div class="card-body">
              <h6 class="card-title text-warning">Vendeurs</h6>
              <p class="display-6"><?= $totalVendeurs ?></p>
            </div>
          </div>
        </div>
        <div class="col-md-2 col-6">
          <div class="card text-center border-info card-hover h-100">
            <div class="card-body">
              <h6 class="card-title text-info">Produits</h6>
              <p class="display-6"><?= $totalProduits ?></p>
            </div>
          </div>
        </div>
        <div class="col-md-2 col-6">
          <div class="card text-center border-secondary card-hover h-100">
            <div class="card-body">
              <h6 class="card-title text-secondary">Commandes</h6>
              <p class="display-6"><?= $totalCommandes ?></p>
            </div>
          </div>
        </div>
      </div>
      <!-- Menu sous forme de cards -->
      <div class="row g-4">
        <div class="col-md-4">
          <a href="admin_gestion.php" class="text-decoration-none">
            <div class="card h-100 shadow-sm border-primary card-hover">
              <div class="card-body text-center">
                <span class="fs-1 text-primary mb-2 d-block"><i class="bi bi-people"></i></span>
                <h5 class="card-title">Gérer les agents</h5>
                <p class="card-text">Ajouter, modifier ou supprimer les agents.</p>
              </div>
            </div>
          </a>
        </div>
        <div class="col-md-4">
          <a href="admin_marche.php" class="text-decoration-none">
            <div class="card h-100 shadow-sm border-success card-hover">
              <div class="card-body text-center">
                <span class="fs-1 text-success mb-2 d-block"><i class="bi bi-shop"></i></span>
                <h5 class="card-title">Gérer les marchés</h5>
                <p class="card-text">Gestion complète des marchés et affectation des agents.</p>
              </div>
            </div>
          </a>
        </div>
        <div class="col-md-4">
          <a href="variation_prix.php" class="text-decoration-none">
            <div class="card h-100 shadow-sm border-info card-hover">
              <div class="card-body text-center">
                <span class="fs-1 text-info mb-2 d-block"><i class="bi bi-bar-chart"></i></span>
                <h5 class="card-title">Voir les statistiques</h5>
                <p class="card-text">Consulter les rapports et statistiques détaillés.</p>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
  <!-- Retirer la carte "Évolution des commandes" -->
  <!--
  <div class="card mb-4">
    <div class="card-header bg-info text-white">
      <h5 class="mb-0">Évolution des commandes (12 derniers mois)</h5>
    </div>
    <div class="card-body">
      <canvas id="chartCommandes" height="80"></canvas>
    </div>
  </div>
  -->
  <div class="card mb-4">
    <div class="card-header bg-warning text-white">
      <h5 class="mb-0">Évolution du prix moyen (12 derniers mois)</h5>
    </div>
    <div class="card-body">
      <canvas id="chartPrix" height="80"></canvas>
    </div>
  </div>
</div>
<!-- Optionnel : Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Supprimer le graphique des commandes
/*
const ctx = document.getElementById('chartCommandes').getContext('2d');
const chartCommandes = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode($labels) ?>,
        datasets: [{
            label: 'Commandes',
            data: <?= json_encode($data) ?>,
            borderColor: '#0d6efd',
            backgroundColor: 'rgba(13,110,253,0.1)',
            fill: true,
            tension: 0.3,
            pointRadius: 4,
            pointBackgroundColor: '#0d6efd'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: { beginAtZero: true }
        }
    }
});
*/
const ctxPrix = document.getElementById('chartPrix').getContext('2d');
const chartPrix = new Chart(ctxPrix, {
    type: 'line',
    data: {
        labels: <?= json_encode($labelsPrix) ?>,
        datasets: [{
            label: 'Prix moyen relevé',
            data: <?= json_encode($dataPrix) ?>,
            borderColor: '#ffc107',
            backgroundColor: 'rgba(255,193,7,0.1)',
            fill: true,
            tension: 0.3,
            pointRadius: 4,
            pointBackgroundColor: '#ffc107'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>
</body>
</html>
<?php
require_once 'footer.php';
?>
