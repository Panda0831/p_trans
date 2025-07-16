<?php
// SESSION et correction des droits
ini_set('session.save_path', '/tmp');
session_start();

// Affichage des erreurs (utile en dev)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



// Initialisation de la variable d’erreur
$error = '';

try {
    // Connexion PDO
    $base = new PDO('mysql:host=localhost;dbname=p_transversal;charset=utf8', 'root', 'Doja1390');
    $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Traitement du formulaire
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (!empty($_POST["nie"]) && !empty($_POST["password"])) {
            $nie = htmlspecialchars(trim($_POST["nie"]));
            $password = trim($_POST["password"]);

            // Récupérer l'utilisateur par le NIE
            $query = $base->prepare("SELECT * FROM ETUDIANT WHERE nie_etudiant = ?");
            $query->execute([$nie]);
            $user = $query->fetch(PDO::FETCH_ASSOC);

            // Vérification du mot de passe
            if ($user && password_verify($password, $user['password'])) {
                // Connexion réussie, on enregistre la session
                $_SESSION['id_etudiant'] = $user['id_etudiant'];
                $_SESSION['nom_etudiant'] = $user['nom_etudiant'];
                $_SESSION['user'] = $user;

                // Vérifie si l'étudiant est aussi un admin
                $checkAdmin = $base->prepare("SELECT COUNT(*) FROM Admin_Club WHERE id_etudiant = ?");
                $checkAdmin->execute([$user['id_etudiant']]);
                $isAdmin = $checkAdmin->fetchColumn() > 0;

                $_SESSION['role'] = $isAdmin ? 'admin' : 'etudiant';

                // Redirection vers la page selon le rôle
                header("Location: " . ($isAdmin ? "admin.php" : "profil.php"));
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
  <link rel="stylesheet" href="login.css"> <!-- Corrige ton chemin ici si besoin -->
</head>
<body>
  <header>
    <div class="header-container">
      <div class="logo">
        <div class="logo-image"><img src="/pages/img/globe.webp" alt="ESMIA University"></div>
        <div class="logo-text">ESMIA UNIVERSITY</div>
      </div>
      <nav>
        <ul>
          <li><a href="accueil.php">Accueil</a></li>
          <li><a href="accueil.php#clubs">Clubs</a></li>
          <li><a href="nous.php">Qui sommes-nous ?</a></li>
          <li><a href="evenement.php">Événements</a></li>
          <li><a href="apropos.html">À propos</a></li>
          <li><a href="login.php" class="btn">Connexion</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <div class="main-content">
    <form class="form-container" method="post" novalidate>
      <h1>Connexion</h1>
      <div class="input-group">
        <label for="nie">Identifiant (NIE) :</label>
        <input type="text" id="nie" name="nie" placeholder="Entrez votre NIE" required
               value="<?= isset($_POST['nie']) ? htmlspecialchars($_POST['nie']) : '' ?>">
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
      <li>GROUPE 3 L1SIO1</li>
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
