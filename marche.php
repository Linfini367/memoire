<?php
session_start();
require_once 'db.php';

$marche_id = $_GET['id'];

// Récupérer le nom du marché
$sql_marche = "SELECT NomMarche FROM marche WHERE IdMarche = ?";
$stmt = $pdo->prepare($sql_marche);
$stmt->execute([$marche_id]);
$marche = $stmt->fetch();

if (!$marche) {
    echo "<div class='alert alert-danger'>Marché introuvable.</div>";
    exit;
}

// Récupérer les vendeurs du marché
$sql = "SELECT * FROM vendeur WHERE IdMarche = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$marche_id]);
$vendeurs = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendeurs - <?php echo $marche['NomMarche']; ?></title>
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
            <h1><?php echo $marche['NomMarche']; ?></h1>
            <p>Liste des vendeurs disponibles</p>
        </div>
    </div>
    <div class="container">
        <div class="vendor-grid">
            <?php foreach($vendeurs as $vendeur): 
                // Compter les produits pour chaque vendeur
                $sql_count = "SELECT COUNT(*) FROM produit WHERE IdVendeur = ?";
                $stmt_count = $pdo->prepare($sql_count);
                $stmt_count->execute([$vendeur['IdVendeur']]);
                $nb_produits = $stmt_count->fetchColumn();
            ?>
                <a href="produits.php?vendeur_id=<?php echo $vendeur['IdVendeur']; ?>" 
                   style="text-decoration: none; color: inherit;">
                    <div class="vendor-card">
                        <img src="./homme-daffaire.png" alt="" style="width:5rem; height:5rem; object-fit:cover; border-radius:50%; margin:0 auto; display:block;">
                        <h3 class="text-center"><?php echo $vendeur['NomVendeur']; ?></h3>
                        <p class="text-center text-muted"><?php echo isset($vendeur['specialite']) ? $vendeur['specialite'] : ''; ?></p>
                        <div class="text-center mt-3">
                            <span class="badge bg-primary">
                                <?php echo $nb_produits; ?> produits
                            </span>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>