<?php

session_start();

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['id_etudiant'])) {
    header("Location: login.php");
    exit();
}

// Connexion à la base
try {
    $pdo = new PDO('mysql:host=localhost;dbname=p_transversal', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer les infos de l'étudiant
    $id = $_SESSION['id_etudiant'];
    $stmt = $pdo->prepare("SELECT * FROM ETUDIANT WHERE id_etudiant = ?");
    $stmt->execute([$id]);
    $etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

    // Récupérer les clubs auxquels il est inscrit
    $clubs_stmt = $pdo->prepare("
        SELECT CLUB.nom_club 
        FROM CLUB 
        JOIN S_inscrire ON CLUB.id_club = S_inscrire.id_club
        WHERE S_inscrire.id_etudiant = ?
    ");
    $clubs_stmt->execute([$id]);
    $clubs = $clubs_stmt->fetchAll(PDO::FETCH_COLUMN);

} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Profil de <?= htmlspecialchars($etudiant['prenom_etudiant']) ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    :root {
      --primary-color: #090057e0;
      --secondary-color: #050b53;
      --text-color: #333;
      --light-bg: #f9f9f9;
    }
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    body {
      font-family: 'Arial', sans-serif;
      background: linear-gradient(120deg, #bfc6e6 0%, #242e59 100%);
      color: var(--text-color);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    header {
      background-color: white;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      padding: 15px 0;
      position: sticky;
      top: 0;
      z-index: 100;
      width: 100%;
    }
    .header-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
    }
    .logo {
      display: flex;
      align-items: center;
    }
    .logo-image img {
      height: 50px;
      margin-right: 15px;
    }
    .logo-text {
      font-weight: bold;
      font-size: 1.5rem;
      color: var(--primary-color);
    }
    nav ul {
      display: flex;
      list-style: none;
    }
    nav ul li {
      margin-left: 30px;
    }
    nav ul li a {
      text-decoration: none;
      color: var(--text-color);
      font-weight: 500;
      transition: color 0.3s;
    }
    nav ul li a:hover {
      color: var(--primary-color);
    }
    .main-content {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 40px 0 0 0;
      width: 100%;
    }
    .profil {
      background: #fff;
      padding: 40px 32px;
      border-radius: 18px;
      box-shadow: 0 6px 24px rgba(0,0,0,0.10);
      max-width: 420px;
      width: 100%;
      margin: 40px auto 0 auto;
      text-align: left;
      border: 2px solid var(--primary-color);
    }
    .profil h2 {
      margin-top: 0;
      color: var(--primary-color);
      font-size: 2rem;
      text-align: center;
      margin-bottom: 18px;
    }
    .profil p {
      margin: 12px 0;
      font-size: 1.05rem;
    }
    .profil strong {
      color: var(--secondary-color);
    }
    .clubs-list {
      margin-top: 10px;
      margin-bottom: 10px;
      color: #444;
      font-weight: bold;
    }
    .logout {
      margin-top: 30px;
      text-align: center;
    }
    .logout a {
      text-decoration: none;
      color: #fff;
      background: var(--primary-color);
      padding: 12px 28px;
      border-radius: 8px;
      font-weight: bold;
      font-size: 1rem;
      transition: background 0.3s;
      border: none;
      display: inline-block;
    }
    .logout a:hover {
      background: var(--secondary-color);
    }
    @media (max-width: 900px) {
      .header-container {
        flex-direction: column;
        gap: 1.5rem;
        padding: 1rem;
      }
      .profil {
        padding: 20px 8px;
      }
    }
    footer {
      background-color: var(--primary-color);
      color: white;
      font-size: large;
      padding: 2cm 1rem;
      margin-top: 50px;
      width: 100vw;
      max-width: 100%;
      box-sizing: border-box;
      display: flex;
      justify-content: center;
      gap: 5cm;
      align-items: flex-start;
      flex-wrap: wrap;
    }

    footer ul {
      flex: 1 1 220px;
      min-width: 200px;
      margin: 0 1rem;
    }

    footer li {
      opacity: 0.9;
      font-size: 0.9rem;
    }

    @media (max-width: 900px) {
      footer {
      flex-direction: column;
      gap: 1.5rem;
      align-items: stretch;
      padding: 2rem 0.5rem;
      }
      footer ul {
      margin: 0.5rem 0;
      }
    }
  </style>
</head>
<body>
  <header>
    <div class="header-container">
      <div class="logo">
        <div class="logo-image"><img src="globe.png" alt="ESMIA University"></div>
        <div class="logo-text">ESMIA UNIVERSITY</div>
      </div>
      <nav>
        <ul>
          <li><a href="acceuil.php">Accueil</a></li>
          <li><a href="profil.php">Mon profil</a></li>
          <li><a href="sosisy.php#clubs">Clubs</a></li>
          <li><a href="logout.php">Déconnexion</a></li>
        </ul>
      </nav>
    </div>
  </header>
  <div class="main-content">
    <div class="profil">
      <h2><?= htmlspecialchars($etudiant['prenom_etudiant'] . " " . $etudiant['nom_etudiant']) ?></h2>
      <p><strong>Email :</strong> <?= htmlspecialchars($etudiant['email_etudiant']) ?></p>
      <p><strong>NIE :</strong> <?= htmlspecialchars($etudiant['nie_etudiant']) ?></p>
      <p><strong>Filière :</strong> <?= htmlspecialchars($etudiant['filiere_etudiant']) ?></p>
      <p><strong>Niveau :</strong> <?= htmlspecialchars($etudiant['niveau_etudiant']) ?></p>
      <p><strong>Classe :</strong> <?= htmlspecialchars($etudiant['classe_etudiant']) ?></p>
      <div class="clubs-list">
        <strong>Club(s) inscrit :</strong>
        <?= !empty($clubs) ? implode(', ', array_map('htmlspecialchars', $clubs)) : "Aucun club inscrit" ?>
      </div>
      <div class="logout">
        <a href="deconnexion.php">Se déconnecter</a>
      </div>
    </div>
  </div>
  <footer>
    <ul style="list-style: none;">
        <p>Notre Equipe:</p><br>
        <li>@ 2025 ESMIA University</li>
        <li>Nexus Tech</li>
        <li>GROUPE 3 L1sio1</li>
    </ul>
    <ul style="list-style: none; text-decoration: none;">
        <p>Coordonnées:</p><br>
        <li style="color: inherit; text-decoration: none;"> facebook</li>
        <li style="color: inherit; text-decoration: none;">Instagram</li>
        <li style="color: inherit; text-decoration: none;">Git Hub</li>
        <li style="color: inherit; text-decoration: none;">Esmia University</li>
    </ul>
    <ul style="list-style: none;">
        <p>Les Résponsables :</p><br>
        <li>AVE President : Fanamby</li>
        <li> Secretaire : Willia Tang</li>
        <li>Trésorier : Ryan</li>
        <li>Conseiller : Joyce</li>
    </ul>
    </footer>
  
  
</body>
</html>