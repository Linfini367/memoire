<?php
session_start();
require_once 'db.php';  // Modification ici pour utiliser db.php

// Modifier aussi la variable de connexion
$marche_id = $_GET['id'];
$sql = "SELECT * FROM vendeurs WHERE marche_id = ?";
$stmt = $pdo->prepare($sql);  // Utilisation de $pdo au lieu de $conn
$stmt->execute([$marche_id]);
$vendeurs = $stmt->fetchAll();

$sql_marche = "SELECT nom FROM marches WHERE id = ?";
$stmt = $pdo->prepare($sql_marche);  // Utilisation de $pdo au lieu de $conn
$stmt->execute([$marche_id]);
$marche = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendeurs - <?php echo $marche['nom']; ?></title>
    <link rel="stylesheet" href="./bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <style>
        .vendor-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            padding: 2rem;
        }
        
        .vendor-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .vendor-card:hover {
            transform: translateY(-5px);
        }
        
        .vendor-image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin: 0 auto 1rem;
            display: block;
            object-fit: cover;
        }
        
        .page-header {
            background: linear-gradient(135deg, #4a90e2, #2c3e50);
            color: white;
            padding: 2rem;
            margin-bottom: 2rem;
            border-radius: 0 0 20px 20px;
        }
    </style>
</head>
<body style="background-color: #f5f5f5;">
    <div class="page-header">
        <div class="container">
            <h1><?php echo $marche['nom']; ?></h1>
            <p>Liste des vendeurs disponibles</p>
        </div>
    </div>

    <div class="container">
        <div class="vendor-grid">
            <?php foreach($vendeurs as $vendeur): ?>
                <a href="produits.php?vendeur_id=<?php echo $vendeur['id']; ?>" 
                   style="text-decoration: none; color: inherit;">
                    <div class="vendor-card">
                        <img src="<?php echo $vendeur['photo'] ?? 'default-vendor.jpg'; ?>" 
                             alt="Photo vendeur" 
                             class="vendor-image">
                        <h3 class="text-center"><?php echo $vendeur['nom']; ?></h3>
                        <p class="text-center text-muted"><?php echo $vendeur['specialite']; ?></p>
                        <div class="text-center mt-3">
                            <span class="badge bg-primary">
                                <?php echo $vendeur['nb_produits']; ?> produits
                            </span>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>