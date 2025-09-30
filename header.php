<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Division Provinciale de l'Économie Nationale - Sud-Kivu/Bukavu</title>
    <link rel="shortcut icon" href="home.png">
    <link rel="stylesheet" href="./bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./bootstrap-5.3.8-dist/css/bootstrap.css">
    <script src="./bootstrap-5.3.8-dist/js/bootstrap.js"></script>
    <script src="./bootstrap-5.3.8-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="Index.css">
</head>
<body>

    <!-- En-tête -->

    <header>
        <div class="container header-content">
            <div class="logo">
                <img src="home.png" alt="logo" width="60" height="60">
                <div class="logo-text">
                    <h1>Suivi des variations du Prix</h1>
                    <span>Division Provinciale de l'Économie Nationale</span>
                </div>
            </div>
            <nav>
                <ul>
                    <?php if (isset($_SESSION['role'])): ?>
                        <?php if ($_SESSION['role'] === 'vendeur'): ?>
                            <li><a href="vendeur_dashboard.php">Accueil vendeur</a></li>
                            <li><a href="valider_commande.php">Valider les commandes</a></li>
                            <li><a href="agent_releve_mensuel.php">Ajouter le prix mensuel</a></li>
                        <?php elseif ($_SESSION['role'] === 'admin'): ?>
                            <li><a href="admin_dashboard.php">Accueil</a></li>
                            <li><a href="admin_marche.php">Gerer les marchés</a></li>
                            <li><a href="admin_gestion.php">Gerer les agents</a></li>
                        <?php elseif ($_SESSION['role'] === 'agent'): ?>
                            <li><a href="agent_dashboard.php">Dashboard agent</a></li>
                        <?php endif; ?>
                        <li><a href="deconnexion.php">Déconnexion</a></li>
                    <?php else: ?>
                        <li><a href="index.php">Accuel</a></li>
                        <li><a href="Apropos.php">A Propos</a></li>
                        <li><a href="Contact.php">Conctactez-nous</a></li>
                        <li><a href="login.php">Connectez-vous</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Bannière principale -->
    <section class="hero">
        <h1></h1>
        <div class="container">
            <div class="hero-content">
                <h2>Surveillance des Prix sur les Marchés de Bukavu</h2>
            </div>
        </div>
    </section>

       <script>
  // Carrousel d'images en background de la section .hero
  const images = [
    "exposition-sur-le-marche-des-fruits-frais.jpg",
    "marche-de-rue-la-nuit.jpg",
    "plan-moyen-mere-et-enfant-au-marche.jpg",
    "beau-marche-de-rue-au-coucher-du-soleil.jpg"
  ];
  let index = 0;
  const hero = document.querySelector(".hero");

  function changeBackground() {
    hero.style.backgroundImage = `url('${images[index]}')`;
    hero.style.backgroundSize = "cover";
    hero.style.backgroundPosition = "center";
    hero.style.backgroundRepeat = "no-repeat";
    index = (index + 1) % images.length;
  }
  // Afficher la première image
  changeBackground();
  // Changer toutes les 10 secondes
  setInterval(changeBackground, 10000);
</script>
</body>
</html>

