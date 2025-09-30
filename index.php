<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
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
                    <li><a href="Apropos.php">A Propos</a></li>
                        <li><a href="Contact.php">Conctactez-nous</a></li>
                    <?php if (isset($_SESSION['role'])): ?>
                        <?php if ($_SESSION['role'] === 'vendeur'): ?>
                            <li><a href="vendeur_dashboard.php">Accueil vendeur</a></li>
                            <li><a href="valider_commande.php">Valider les commandes</a></li>
                        <?php elseif ($_SESSION['role'] === 'admin'): ?>
                            <li><a href="admin_dashboard.php">Accueil</a></li>
                            <li><a href="admin_marche.php">Gerer les marchés</a></li>
                            <li><a href="admin_gestion.php">Gerer les agents</a></li>
                        <?php elseif ($_SESSION['role'] === 'agent'): ?>
                            <li><a href="agent_dashboard.php">Dashboard agent</a></li>
                        <?php endif; ?>
                        <li><a href="deconnexion.php">Déconnexion</a></li>
                    <?php else: ?>
                        <li><a href="login.php">Connectez-vous</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main style="margin-top: 0px; background-image: url('beau-marche-de-rue-au-coucher-du-soleil.jpg'); background-size: cover; background-position: center; min-height: 100vh; display: flex; flex-direction:column; justify-content: center; align-items: center;">
        <h2 class="text-white mb-5" style="color:white; font-size:2rem;margin-bottom:5rem;">Choisissez un marché pour commander votre produit</h2>
        <div class="container" style="background-color: rgba(255, 255, 255, 0.07); padding: 20px; border-radius: 8px; width: 800px; display: flex; flex-direction: row; justify-content: center; gap: 20px;">
            <a href="marche.php?id=3" style="text-decoration: none; color: black; flex: 1; transition: transform 0.3s;">
                <div class="text-center" style="background-color: rgba(255, 255, 255, 0.83); padding: 20px; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); hover: transform: scale(1.05);">
                    <h2>MARCHE DE KADUTU</h2>
                </div>
            </a>
            <a href="marche.php?id=2" style="text-decoration: none; color: black; flex: 1; transition: transform 0.3s;">
                <div class="text-center" style="background-color: rgba(255, 255, 255, 0.83); padding: 20px; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); hover: transform: scale(1.05);">
                    <h2>MARCHE DE NYAWERA</h2>
                </div>
            </a>
        </div>
    </main>
</body>
</html>