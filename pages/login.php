<?php
session_start();
$error = '';

try {
    $base = new PDO('mysql:host=localhost;dbname=p_transversal', 'root', 'Doja1390');
    $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (!empty($_POST["nie"]) && !empty($_POST["password"])) {
            $nie = htmlspecialchars(trim($_POST["nie"]));
            $password = trim($_POST["password"]);

            $query = $base->prepare("SELECT * FROM ETUDIANT WHERE nie_etudiant = ?");
            $query->execute([$nie]);
            $user = $query->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['id_etudiant'] = $user['id_etudiant'];
                $_SESSION['nom_etudiant'] = $user['nom_etudiant'];
                $_SESSION['user'] = $user;

                // Vérifie si l'utilisateur est admin
                $checkAdmin = $base->prepare("SELECT COUNT(*) FROM Admin_Club WHERE id_etudiant = ?");
                $checkAdmin->execute([$user['id_etudiant']]);
                $isAdmin = $checkAdmin->fetchColumn() > 0;

                // Enregistre le rôle dans la session
                $_SESSION['role'] = $isAdmin ? 'admin' : 'etudiant';

                // Redirection selon le rôle
                header("Location: " . ($isAdmin ? "/admin/admin.php" : "/pages/profil.php"));
                exit();
            } else {
                $error = "❌ Identifiant ou mot de passe incorrect.";
            }
        } else {
            $error = "⚠️ Veuillez remplir tous les champs.";
        }
    }
} catch (PDOException $e) {
    $error = "Erreur de connexion à la base de données : " . htmlspecialchars($e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Connexion - ESMIA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="/view/login.css">
  <style>
    
  </style>
</head>
<body>
  <header>
    <div class="header-container">
      <div class="logo">
        <div class="logo-image"><img src="./img/globe.webp" alt="ESMIA University"></div>
        <div class="logo-text">ESMIA UNIVERSITY</div>
      </div>
      <nav>
        <ul>
          
          <li><a href="accueil.php">Accueil</a></li>
          <li><a href="accueil.php#clubs">Clubs</a></li>
          <li><a href="nous.php">Qui-sommes-nous?</a></li>
          <li><a href="evenement.php">Événements</a></li>
          <li><a href="apropos.html">À propos</a></li>
          <li><a href="login.php" class="btn">Connexion</a></li>
        </ul>
        <?php
        // Check if the user is logged in and display the logout button
       
        ?>
      </nav>
    </div>
  </header>
  <div class="main-content">
    <form class="form-container" action="" method="post" novalidate>
      <h1>Connexion</h1>
      <div class="input-group">
        <label for="nie">Identifiant :</label>
        <input type="text" id="nie" name="nie" placeholder="Entrez votre NIE" required value="<?= isset($_POST['nie']) ? htmlspecialchars($_POST['nie']) : '' ?>">
      </div>
      <div class="input-group">
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe" required>
      </div>
      <div class="btn-group">
        <a href="inscription.php">S'inscrire</a>
        <button type="submit">Se connecter</button>
      </div>
      <?php if ($error): ?>
        <div class="error-message"><?= $error ?></div>
      <?php endif; ?>
    </form>
  </div>
  <footer>
    <ul>
      <p>Notre Équipe :</p>
      <li>@ 2025 ESMIA University</li>
      <li><a href="https://github.com/nexus-tech5">Nexus Tech</a></li>
      <li>GROUPE 3 L1sio1</li>
    </ul>
    <ul>
      <p>Coordonnées :</p>
      <li><a href="#">Facebook</a></li>
      <li><a href="#">Instagram</a></li>
      <li><a href="#">GitHub</a></li>
      <li>Esmia University</li>
    </ul>
    <ul>
      <p>Les Responsables :</p>
      <li>Président : Fanamby</li>
      <li>Secrétaire : Willia Tang</li>
      <li>Trésorier : Ryan</li>
      <li>Conseiller : Joyce</li>
    </ul>
  </footer>
</body>
</html>