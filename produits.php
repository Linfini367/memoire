<?php
session_start();
require_once 'db.php';

// Vérifier que le paramètre vendeur_id existe et est valide
if (!isset($_GET['vendeur_id']) || !is_numeric($_GET['vendeur_id'])) {
    echo "<div class='alert alert-danger'>Vendeur non spécifié.</div>";
    exit;
}

$vendeur_id = intval($_GET['vendeur_id']);

// Récupérer les produits du vendeur
$sql = "SELECT * FROM produit WHERE IdVendeur = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$vendeur_id]);
$produits = $stmt->fetchAll();

// Récupérer les infos du vendeur
$sql_vendeur = "SELECT * FROM vendeur WHERE IdVendeur = ?";
$stmt = $pdo->prepare($sql_vendeur);
$stmt->execute([$vendeur_id]);
$vendeur = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produits de <?php echo $vendeur ? $vendeur['NomVendeur'] : ''; ?></title>
    <link rel="stylesheet" href="./vendor/bootstrap/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
            <h1>Produits de <?php echo $vendeur ? $vendeur['NomVendeur'] : 'Vendeur inconnu'; ?></h1>
        </div>
    </div>

    <div class="container">
        <div class="product-grid">
            <?php foreach($produits as $produit): ?>
                <div class="product-card">
                    <img src="./produits-chimiques.png" alt="" style="width:5rem; height:5rem; object-fit:cover; margin:0 auto; display:block;">
                    <div class="product-info">
                        <h3><?php echo $produit['NomProduit']; ?></h3>
                        <p class="text-muted"><?php echo $produit['Description']; ?></p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                        </div>
                        <a class="btn btn-primary" href="demande_commande.php?idProduit=<?= $produit['IdProduit'] ?>&vendeur_id=<?= $vendeur_id ?>" >Demander ce produit</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>