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
    <main style="margin-top: 0px; background-image: url('beau-marche-de-rue-au-coucher-du-soleil.jpg'); background-size: cover; background-position: center; min-height: 100vh;">
        <div class="container " style="background-color: rgba(255, 255, 255, 0.07); padding: 20px; border-radius: 8px; margin-top: 20px; dysplay: flex; align-items: center; justify-content: center; color: black; width: 300px; height: 150px; justify-content: space-between;">
            <a href="" class="mb-3" style ="text-decoration: none; color: black;">
            <div class="mb-4 text-center" style="background-color: rgba(255, 255, 255, 0.83); padding: 10px; border-radius: 5px;">
                <h2>MARCHE KADUTU</h2>
            </div>
            </a>
            
            <a href="" class="mb-3" style ="text-decoration: none; color: black;">
            <div class="mb-4 text-center" style="background-color: rgba(255, 255, 255, 0.83); padding: 10px; border-radius: 5px;">
                <h2>MARCHE NYAWERA</h2>
            </div>
            </a>
        </div>
    </main>
</body>
</html>