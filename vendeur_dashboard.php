<?php
session_start();
require 'db.php';
require 'header.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'vendeur' || !isset($_SESSION['id'])) {
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Accueil Vendeur</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
    <div class="container mt-5">
        <div class="alert alert-warning text-center">Connectez-vous pour voir vos produits.</div>
    </div>
    </body>
    </html>
    <?php
    exit;
}

$idVendeur = $_SESSION['id'];

// Traitement ajout produit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter'])) {
    $nom = $_POST['nom'];
    $desc = $_POST['description'];
    $prix = $_POST['prix']; // <-- Ajouté
    $idMarche = $_POST['idmarche'];
    $dateMaj = date('Y-m-d');
    $stmt = $pdo->prepare("INSERT INTO produit (NomProduit, Description, Prix, IdVendeur, IdMarche, DateMaj) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nom, $desc, $prix, $idVendeur, $idMarche, $dateMaj]);
    header("Location: vendeur_dashboard.php");
    exit;
}

// Traitement suppression produit
if (isset($_GET['supprimer'])) {
    $idProduit = (int)$_GET['supprimer'];
    $stmt = $pdo->prepare("DELETE FROM produit WHERE IdProduit = ? AND IdVendeur = ?");
    $stmt->execute([$idProduit, $idVendeur]);
    header("Location: vendeur_dashboard.php");
    exit;
}

// Traitement modification produit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifier'])) {
    $idProduit = $_POST['idproduit'];
    $nom = $_POST['nom'];
    $desc = $_POST['description'];
    $idMarche = $_POST['idmarche'];
    $dateMaj = date('Y-m-d');
    $stmt = $pdo->prepare("UPDATE produit SET NomProduit=?, Description=?, IdMarche=?, DateMaj=? WHERE IdProduit=? AND IdVendeur=?");
    $stmt->execute([$nom, $desc, $idMarche, $dateMaj, $idProduit, $idVendeur]);
    header("Location: vendeur_dashboard.php");
    exit;
}

// Récupérer les produits du vendeur
$produits = $pdo->prepare("SELECT p.*, m.NomMarche FROM produit p LEFT JOIN marche m ON p.IdMarche = m.IdMarche WHERE p.IdVendeur = ?");
$produits->execute([$idVendeur]);
$listeProduits = $produits->fetchAll();

// Récupérer la liste des marchés pour le formulaire
$marches = $pdo->query("SELECT IdMarche, NomMarche FROM marche")->fetchAll();

// Récupérer le nom du vendeur connecté
$stmtVendeur = $pdo->prepare("SELECT NomVendeur FROM vendeur WHERE IdVendeur = ?");
$stmtVendeur->execute([$idVendeur]);
$nomVendeur = $stmtVendeur->fetchColumn();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil Vendeur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./vendor/fontawesome-free/css/all.min.css">
</head>
<body>
<div class="container mt-5 mb-5">
    <h2 class="mb-4 text-center">Bienvenue <span class="text-success"><?= htmlspecialchars($nomVendeur) ?></span>, voici vos produits</h2>
    <!-- Formulaire d'ajout -->
    <div class="card mb-4">
        <div class="card-header bg-success text-white">Ajouter un produit</div>
        <div class="card-body">
            <form method="post" class="row g-3">
                <div class="col-md-3">
                    <input type="text" name="nom" class="form-control" placeholder="Nom du produit" required>
                </div>
                <div class="col-md-3">
                    <input type="text" name="description" class="form-control" placeholder="Description" required>
                </div>
                <div class="col-md-2">
                    <input type="number" step="0.01" name="prix" class="form-control" placeholder="Prix" required>
                </div>
                <div class="col-md-3">
                    <select name="idmarche" class="form-select" required>
                        <option value="">Marché</option>
                        <?php foreach ($marches as $marche): ?>
                            <option value="<?= $marche['IdMarche'] ?>"><?= htmlspecialchars($marche['NomMarche']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" name="ajouter" class="btn btn-success w-100">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- Tableau des produits -->
    <div class="card">
        <div class="card-header bg-primary text-white">Vos produits</div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Prix</th>
                        <th>Marché</th>
                        <th>Date Maj</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($listeProduits as $prod): ?>
                    <?php if (isset($_GET['edit']) && $_GET['edit'] == $prod['IdProduit']): ?>
                        <!-- Formulaire de modification -->
                        <tr>
                            <form method="post" class="row">
                                <td><input type="text" name="nom" value="<?= htmlspecialchars($prod['NomProduit']) ?>" class="form-control" required></td>
                                <td><input type="text" name="description" value="<?= htmlspecialchars($prod['Description']) ?>" class="form-control" required></td>
                                <td><input type="number" step="0.01" name="prix" value="<?= htmlspecialchars($prod['Prix']) ?>" class="form-control" required></td>
                                <td>
                                    <select name="idmarche" class="form-select" required>
                                        <?php foreach ($marches as $marche): ?>
                                            <option value="<?= $marche['IdMarche'] ?>" <?= $prod['IdMarche'] == $marche['IdMarche'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($marche['NomMarche']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td><?= htmlspecialchars($prod['DateMaj']) ?></td>
                                <td>
                                    <input type="hidden" name="idproduit" value="<?= $prod['IdProduit'] ?>">
                                    <button type="submit" name="modifier" class="btn btn-primary btn-sm">Enregistrer</button>
                                    <a href="vendeur_dashboard.php" class="btn btn-secondary btn-sm">Annuler</a>
                                </td>
                            </form>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td><?= htmlspecialchars($prod['NomProduit']) ?></td>
                            <td><?= htmlspecialchars($prod['Description']) ?></td>
                            <td><?= htmlspecialchars($prod['Prix']) ?></td>
                            <td><?= htmlspecialchars($prod['NomMarche']) ?></td>
                            <td><?= htmlspecialchars($prod['DateMaj']) ?></td>
                            <td>
                                <a href="vendeur_dashboard.php?edit=<?= $prod['IdProduit'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                                <a href="vendeur_dashboard.php?supprimer=<?= $prod['IdProduit'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce produit ?')">Supprimer</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php if (empty($listeProduits)): ?>
                    <tr><td colspan="6" class="text-center text-muted">Aucun produit trouvé.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
    require 'footer.php';
?>
</body>
</html>
