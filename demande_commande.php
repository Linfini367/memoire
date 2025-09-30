<?php
session_start();
require 'db.php';

$idProduit = isset($_GET['idProduit']) ? intval($_GET['idProduit']) : 0;
$vendeur_id = isset($_GET['vendeur_id']) ? intval($_GET['vendeur_id']) : 0;

$_SESSION['vendeur_id'] = $vendeur_id;

$produit = null;
$marche = null;

if ($idProduit) {
    $stmt = $pdo->prepare("SELECT p.*, m.NomMarche, m.IdMarche FROM produit p JOIN marche m ON p.IdMarche = m.IdMarche WHERE p.IdProduit = ?");
    $stmt->execute([$idProduit]);
    $produit = $stmt->fetch();
    if ($produit) {
        $marche = [
            'IdMarche' => $produit['IdMarche'],
            'NomMarche' => $produit['NomMarche']
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Demande de commande</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="card shadow">
      <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Soumettre une demande de commande</h4>
      </div>
      <div class="card-body">
        <form action="traitement_demande.php" method="POST">
          <div class="mb-3">
            <label class="form-label">Nom de l'acheteur</label>
            <input type="text" name="nomAcheteur" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Post-nom de l'acheteur</label>
            <input type="text" name="postNomAcheteur" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Marchandise</label>
            <input type="text" class="form-control" value="<?= $produit ? $produit['NomProduit'] : '' ?>" disabled>
            <input type="hidden" name="idProduit" value="<?= $produit ? $produit['IdProduit'] : '' ?>">
          </div>

          <div class="mb-3">
            <label class="form-label">Marché</label>
            <input type="text" class="form-control" value="<?= $marche ? $marche['NomMarche'] : '' ?>" disabled>
            <input type="hidden" name="idMarche" value="<?= $marche ? $marche['IdMarche'] : '' ?>">
          </div>

          <div class="mb-3">
            <label class="form-label">Prix du produit</label>
            <input type="number" class="form-control" value="<?= $produit ? $produit['Prix'] : '' ?>" disabled>
            <input type="hidden" name="prixProduit" value="<?= $produit ? $produit['Prix'] : '' ?>">
          </div>

          <div class="mb-3">
            <label class="form-label">Prix proposé</label>
            <input type="number" step="0.01" name="prixPropose" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Date de la demande</label>
            <input type="date" name="dateDemande" class="form-control" value="<?= date('Y-m-d') ?>" required>
          </div>

          <input type="hidden" name="vendeur_id" value="<?= $vendeur_id ?>">

          <button type="submit" class="btn btn-success">Soumettre la demande</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
