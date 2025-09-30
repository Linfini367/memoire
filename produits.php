<?php
session_start();
require_once 'db.php';  // Modification ici pour utiliser db.php

$vendeur_id = $_GET['vendeur_id'];
$sql = "SELECT p.*, v.nom as vendeur_nom 
        FROM produits p 
        JOIN vendeurs v ON p.vendeur_id = v.id 
        WHERE v.id = ?";
$stmt = $pdo->prepare($sql);  // Utilisation de $pdo au lieu de $conn
$stmt->execute([$vendeur_id]);
$produits = $stmt->fetchAll();

$sql_vendeur = "SELECT * FROM vendeur WHERE id = ?";
$stmt = $pdo->prepare($sql_vendeur);  // Utilisation de $pdo au lieu de $conn
$stmt->execute([$vendeur_id]);
$vendeur = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produits de <?php echo $vendeur['nom']; ?></title>
    <link rel="stylesheet" href="./bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <style>
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 2rem;
            padding: 2rem;
        }
        
        .product-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
        }
        
        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        
        .product-info {
            padding: 1.5rem;
        }
        
        .vendor-header {
            background: linear-gradient(135deg, #2c3e50, #3498db);
            color: white;
            padding: 2rem;
            margin-bottom: 2rem;
            border-radius: 0 0 20px 20px;
        }
        
        .price {
            font-size: 1.25rem;
            font-weight: bold;
            color: #2c3e50;
        }
    </style>
</head>
<body style="background-color: #f5f5f5;">
    <div class="vendor-header">
        <div class="container">
            <h1>Produits de <?php echo $vendeur['nom']; ?></h1>
            <p><?php echo $vendeur['specialite']; ?></p>
        </div>
    </div>

    <div class="container">
        <div class="product-grid">
            <?php foreach($produits as $produit): ?>
                <div class="product-card">
                    <img src="<?php echo $produit['image'] ?? 'default-product.jpg'; ?>" 
                         alt="<?php echo $produit['nom']; ?>" 
                         class="product-image">
                    <div class="product-info">
                        <h3><?php echo $produit['nom']; ?></h3>
                        <p class="text-muted"><?php echo $produit['description']; ?></p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="price">$<?php echo $produit['prix']; ?></span>
                            <span class="badge bg-<?php echo $produit['en_stock'] ? 'success' : 'danger'; ?>">
                                <?php echo $produit['en_stock'] ? 'En stock' : 'Rupture'; ?>
                            </span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>