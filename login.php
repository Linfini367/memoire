<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $mdp = $_POST['motdepasse'];

  // Vérifier dans admin
  $admin = $pdo->prepare("SELECT * FROM admin WHERE EmailAdmin = ? AND MotDePasseAdmin = ?");
  $admin->execute([$email, $mdp]);
  if ($admin->rowCount()) {
    $_SESSION['role'] = 'admin';
    $_SESSION['id'] = $admin->fetch()['IdAdmin'];
    header('Location: admin_dashboard.php');
    exit;
  }

  // Vérifier dans agent
  $agent = $pdo->prepare("SELECT * FROM agent WHERE EmailAgent = ? AND MotDePasseAgent = ?");
  $agent->execute([$email, $mdp]);
  if ($agent->rowCount()) {
    $_SESSION['role'] = 'agent';
    $_SESSION['id'] = $agent->fetch()['IdAgent'];
    header('Location: agent_dashboard.php');
    exit;
  }

  // Vérifier dans vendeur
  $vendeur = $pdo->prepare("SELECT * FROM vendeur WHERE EmailVendeur = ? AND MotDePasseVendeur = ?");
  $vendeur->execute([$email, $mdp]);
  if ($vendeur->rowCount()) {
    $_SESSION['role'] = 'vendeur';
    $_SESSION['id'] = $vendeur->fetch()['IdVendeur'];
    header('Location: vendeur_dashboard.php');
    exit;
  }

  // Acheteur n’a pas d’email/mot de passe dans ta base actuelle
  // Tu peux l’ajouter si tu veux qu’il se connecte aussi

  echo "<div style='padding:20px;font-family:sans-serif;color:red;'>❌ Identifiants incorrects.</div>";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Connexion</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="card shadow w-50 mx-auto">
      <div class="card-header bg-primary text-white">
        <h4 class="mb-0">🔐 Connexion</h4>
      </div>
      <div class="card-body">
        <form method="POST">
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Mot de passe</label>
            <input type="password" name="motdepasse" class="form-control" required>
          </div>
          <button type="submit" class="btn btn-success">Se connecter</button>
          <a href="inscription.php" class="" style="list-style:none;">S'inscrire</a>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
