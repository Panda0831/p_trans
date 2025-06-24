<?php
session_start();

// Vérifie que l'utilisateur est bien connecté
if (!isset($_SESSION['id_etudiant'])) {
    header("Location: login.php");
    exit();
}

// Connexion à la base
$pdo = new PDO('mysql:host=localhost;dbname=projet', 'root', 'Doja1390');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Récupération des infos de l'utilisateur connecté
$id = $_SESSION['id_etudiant'];
$stmt = $pdo->prepare("SELECT * FROM ETUDIANT WHERE id_etudiant = ?");
$stmt->execute([$id]);
$etudiant = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Profil de <?= htmlspecialchars($etudiant['prenom_etudiant']) ?></title>
  <style>
    body {
      font-family: sans-serif;
      background-image: url('89781.jpg');
      background-size: cover;
      background-color: gray;
      text-align: center;
      padding: 50px;
    }
    .profil {
      background: gray;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
      display: inline-block;
      max-width: 400px;
      height: 500px;
    }
    .profil h2 {
      margin-top: 0;
    }
    .profil p {
      margin: 8px 0;
    }
    .logout {
      margin-top: 20px;
    }
    .logout a {
      text-decoration: none;
      color: white;
      background: #8a2be2;
      padding: 10px 20px;
      border-radius: 8px;
      font-weight: bold;
    }
   
.navbar {
  background: transparent;
  padding: 15px 0;
  position: fixed;
  top: 0;
  left: -70vh;
  width: 100%;
  z-index: 1000;
}

.navbar ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  text-align: center;
}

.navbar li {
  display: inline;
  margin: 0 20px;
}

.navbar a {
  color: black;
  text-decoration: none;
  font-weight: bold;
  font-size: 16px;
  transition: color 0.3s;
}

.navbar a:hover {
  color: #a3baff;
}


  </style>
</head>
<body>
<nav class="navbar">
  <ul>
    <li><a href="acceuil.php">Accueil</a></li>
    <li><a href="profil.php">Mon profil</a></li>
    <li><a href="liste_clubs.php">Clubs</a></li>
    <li><a href="logout.php">Déconnexion</a></li>
  </ul>
</nav>


<div class="profil">
    
  <h2><?= htmlspecialchars($etudiant['prenom_etudiant'] . " " . $etudiant['nom_etudiant']) ?></h2>
  <p><strong>Email :</strong> <?= htmlspecialchars($etudiant['email_etudiant']) ?></p>
  <p><strong>NIE :</strong> <?= htmlspecialchars($etudiant['nie_etudiant']) ?></p>
  <p><strong>Filière :</strong> <?= htmlspecialchars($etudiant['filiere_etudiant']) ?></p>
  <p><strong>Niveau :</strong> <?= htmlspecialchars($etudiant['niveau_etudiant']) ?></p>
  <p><strong>Classe :</strong> <?= htmlspecialchars($etudiant['classe_etudiant']) ?></p>
  <p><strong>club(s) inscrit :</strong> <?= htmlspecialchars($etudiant['club_etudiant']) ?></p>


  <div class="logout">
    <a href="logout.php">Se déconnecter</a>
  </div>
</div>

</body>
</html>
a