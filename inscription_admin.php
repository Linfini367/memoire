<?php
require 'db.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $mdp = $_POST['motdepasse'];
    $stmt = $pdo->prepare("INSERT INTO admin (NomAdmin, EmailAdmin, MotDePasseAdmin) VALUES (?, ?, ?)");
    $ok = $stmt->execute([$nom, $email, $mdp]);
    $message = $ok ? "Inscription admin réussie !" : "Erreur lors de l'inscription.";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow w-50 mx-auto">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">📝 Inscription Admin</h4>
        </div>
        <div class="card-body">
            <?php if ($message): ?>
                <div class="alert alert-info"><?= $message ?></div>
            <?php endif; ?>
            <form method="post">
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
        </div>
    </div>
</div>
</body>
</html>