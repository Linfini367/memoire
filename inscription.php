<?php

require 'db.php';

$type = $_POST['type'] ?? $_GET['type'] ?? null;
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $type) {
    if ($type === 'admin') {
        $nom = $_POST['nom'];
        $email = $_POST['email'];
        $mdp = $_POST['motdepasse'];
        $stmt = $pdo->prepare("INSERT INTO admin (NomAdmin, EmailAdmin, MotDePasseAdmin) VALUES (?, ?, ?)");
        $ok = $stmt->execute([$nom, $email, $mdp]);
        $message = $ok ? "Inscription admin réussie !" : "Erreur lors de l'inscription.";
    }
    if ($type === 'agent') {
        $nom = $_POST['nom'];
        $email = $_POST['email'];
        $mdp = $_POST['motdepasse'];
        $idadmin = 1; // ou laissez choisir l'admin
        $stmt = $pdo->prepare("INSERT INTO agent (NomAgent, EmailAgent, MotDePasseAgent, IdAdmin) VALUES (?, ?, ?, ?)");
        $ok = $stmt->execute([$nom, $email, $mdp, $idadmin]);
        $message = $ok ? "Inscription agent réussie !" : "Erreur lors de l'inscription.";
    }
    if ($type === 'vendeur') {
        $nom = $_POST['nom'];
        $email = $_POST['email'];
        $mdp = $_POST['motdepasse'];
        $stmt = $pdo->prepare("INSERT INTO vendeur (NomVendeur, EmailVendeur, MotDePasseVendeur) VALUES (?, ?, ?)");
        $ok = $stmt->execute([$nom, $email, $mdp]);
        $message = $ok ? "Inscription vendeur réussie !" : "Erreur lors de l'inscription.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow w-50 mx-auto">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">📝 Inscription</h4>
        </div>
        <div class="card-body">
            <?php if ($message): ?>
                <div class="alert alert-info"><?= $message ?></div>
            <?php endif; ?>
            <?php if (!$type): ?>
                <form method="get">
                    <div class="mb-3">
                        <label class="form-label">Je veux m'inscrire en tant que :</label>
                        <select name="type" class="form-select" required>
                            <option value="">Choisir...</option>
                            <option value="admin">Admin</option>
                            <option value="agent">Agent</option>
                            <option value="vendeur">Vendeur</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Continuer</button>
                </form>
            <?php else: ?>
                <form method="post">
                    <input type="hidden" name="type" value="<?= htmlspecialchars($type) ?>">
                    <div class="mb-3">
                        <label class="form-label">Nom</label>
                        <input type="text" name="nom" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mot de passe</label>
                        <input type="password" name="motdepasse" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success">S'inscrire</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>