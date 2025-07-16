<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Connexion à la base de données
$host = "localhost";
$user = "root";
$pass = "Doja1390";
$dbname = "p_transversal";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupérer et nettoyer les données
    $nom      = htmlspecialchars(trim($_POST["nom"] ?? ""));
    $prenom   = htmlspecialchars(trim($_POST["prenom"] ?? ""));
    $email    = htmlspecialchars(trim($_POST["email"] ?? ""));
    $nie      = htmlspecialchars(trim($_POST["nie"] ?? ""));
    $password = $_POST["password"] ?? "";
    $confirm  = $_POST["confirm_password"] ?? "";
    $filiere  = htmlspecialchars(trim($_POST["filiere"] ?? ""));
    $niveau   = htmlspecialchars(trim($_POST["niveau"] ?? ""));
    $classe   = htmlspecialchars(trim($_POST["classe"] ?? ""));

    // Vérifie que les champs obligatoires sont remplis
    if (!$nom || !$prenom || !$email || !$nie || !$password || !$confirm || !$filiere || !$niveau || !$classe) {
        die("Tous les champs sont requis.");
    }

    // Vérifie que les mots de passe correspondent
    if ($password !== $confirm) {
        die(" Les mots de passe ne correspondent pas.");
    }

    // Génère un ID unique pour l'étudiant
$id_etudiant = "ETU" . substr(uniqid(), -7);
    


    // Hasher le mot de passe
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Requête d'insertion
    try {
        $sql = "INSERT INTO ETUDIANT (
                    id_etudiant, nom_etudiant, prenom_etudiant, email_etudiant, nie_etudiant,
                    filiere_etudiant, niveau_etudiant, classe_etudiant, password
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $ok = $stmt->execute([
            $id_etudiant,
            $nom,
            $prenom,
            $email,
            $nie,
            $filiere,
            $niveau,
            $classe,
            $hashed_password
        ]);

        if ($ok) {
            // Redirection vers une page de confirmation
            header("Location: accueil.php");
            exit();
        } else {
            echo " Erreur lors de l'inscription.";
        }

    } catch (PDOException $e) {
        echo " Erreur SQL : " . $e->getMessage();
    }
}

// Fermeture de la connexion
$conn = null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Inscription - Clubs ESMIA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="inscription.css">
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
          <li><a href="profil.php">Profil</a></li>
          <li><a href="accueil.php">Accueil</a></li>
          <li><a href="accueil.php#clubs">Clubs</a></li>
          <li><a href="nous.php">Qui sommes nous?</a></li>
          <li><a href="evenement.php">Événements</a></li>
          <li><a href="apropos.php">À propos</a></li>
          <li><a href="login.php" class="btn">Connexion</a></li>
        </ul>
      </nav>
    </div>
  </header>
  <div class="main-content">
    <div class="container">
      <h1>Formulaire</h1>
      <h2>Inscription</h2>
      <form method="post" action="inscription.php">
        <div class="form-group">
          <label for="nom">Nom :</label>
          <input type="text" id="nom" name="nom" required>
        </div>
        <div class="form-group">
          <label for="prenom">Prénom :</label>
          <input type="text" id="prenom" name="prenom" required>
        </div>
        <div class="form-group">
          <label for="email">Email :</label>
          <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
          <label for="nie">NIE :</label>
          <input type="text" id="nie" name="nie" required>
        </div>
        <div class="form-group">
          <label for="password">Mot de passe :</label>
          <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
          <label for="confirm_password">Confirmer le mot de passe :</label>
          <input type="password" id="confirm_password" name="confirm_password" required>
        </div>
        <div class="form-group">
          <label for="filiere">Filière :</label>
          <input type="text" id="filiere" name="filiere">
        </div>
        <div class="form-group">
          <label for="niveau">Niveau :</label>
          <input type="text" id="niveau" name="niveau">
        </div>
        <div class="form-group">
          <label for="classe">Classe :</label>
          <input type="text" id="classe" name="classe">
        </div>
        <button type="submit" class="submit-btn">S'inscrire</button>
      </form>
    </div>
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