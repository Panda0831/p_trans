// profil.php
<?php
session_start();

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['id_etudiant'])) {
    header("Location: login.php");
    exit();
}

// Connexion à la base
try {
    $pdo = new PDO('mysql:host=localhost;dbname=p_transversal', 'root', 'Doja1390');
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
      --main-bg: #181c2f;
      --accent: #6c63ff;
      --accent-light: #a7a3ff;
      --white: #fff;
      --gray: #e5e7ef;
      --text: #232946;
      --shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18);
    }
    body {
      background: linear-gradient(120deg, var(--main-bg) 60%, var(--accent-light) 100%);
      font-family: 'Segoe UI', 'Arial', sans-serif;
      color: var(--white);
      margin: 0;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    header {
      background: rgba(24,28,47,0.95);
      box-shadow: var(--shadow);
      padding: 0.5rem 0;
      position: sticky;
      top: 0;
      z-index: 100;
    }
    .header-container {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 2rem;
    }
    .logo {
      display: flex;
      align-items: center;
      gap: 1rem;
    }
    .logo-image img {
      height: 48px;
      border-radius: 12px;
      box-shadow: 0 2px 8px #0002;
      background: var(--white);
      padding: 4px;
    }
    .logo-text {
      font-weight: 700;
      font-size: 1.6rem;
      letter-spacing: 2px;
      color: var(--accent);
      text-shadow: 0 2px 8px #0002;
    }
    nav ul {
      display: flex;
      gap: 2rem;
      list-style: none;
      margin: 0;
      padding: 0;
    }
    nav ul li a {
      color: var(--white);
      text-decoration: none;
      font-weight: 500;
      padding: 0.5rem 1rem;
      border-radius: 6px;
      transition: background 0.2s, color 0.2s;
    }
    nav ul li a.btn {
      background: var(--accent);
      color: var(--white);
      font-weight: bold;
      box-shadow: 0 2px 8px #6c63ff44;
    }
    nav ul li a:hover, nav ul li a.btn:hover {
      background: var(--accent-light);
      color: var(--main-bg);
    }
    .main-content {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 3rem 1rem 2rem 1rem;
    }
    .profil {
      background: rgba(255,255,255,0.09);
      padding: 40px 32px;
      border-radius: 18px;
      box-shadow: var(--shadow);
      max-width: 420px;
      width: 100%;
      margin: 40px auto 0 auto;
      text-align: left;
      color: var(--text);
      border: 2px solid var(--accent);
    }
    .profil h2 {
      margin-top: 0;
      color: var(--accent);
      font-size: 2rem;
      text-align: center;
      margin-bottom: 18px;
    }
    .profil p {
      margin: 12px 0;
      font-size: 1.05rem;
      color: var(--white);
    }
    .profil strong {
      color: var(--accent-light);
    }
    .clubs-list {
      margin-top: 10px;
      margin-bottom: 10px;
      color: #fff;
      font-weight: bold;
    }
    .logout {
      margin-top: 30px;
      text-align: center;
    }
    .logout a {
      text-decoration: none;
      color: #fff;
      background: var(--accent);
      padding: 12px 28px;
      border-radius: 8px;
      font-weight: bold;
      font-size: 1rem;
      transition: background 0.3s;
      border: none;
      display: inline-block;
    }
    .logout a:hover {
      background: var(--accent-light);
      color: var(--main-bg);
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
      background: var(--main-bg);
      color: var(--gray);
      padding: 2.5rem 2rem 2rem 2rem;
      margin-top: 3rem;
      border-radius: 2rem 2rem 0 0;
      box-shadow: 0 -2px 16px #0002;
      display: flex;
      flex-wrap: wrap;
      gap: 3rem;
      justify-content: center;
      font-size: 1rem;
    }
    footer ul {
      list-style: none;
      padding: 0;
      margin: 0;
      min-width: 180px;
    }
    footer p {
      font-weight: 700;
      color: var(--accent);
      margin-bottom: 0.5rem;
    }
    footer li, footer a {
      color: var(--gray);
      text-decoration: none;
      margin-bottom: 0.3rem;
      display: block;
      opacity: 0.95;
      transition: color 0.2s;
    }
    footer a:hover {
      color: var(--accent-light);
      text-decoration: underline;
    }
    @media (max-width: 700px) {
      .header-container {
        flex-direction: column;
        gap: 1rem;
      }
      .main-content {
        padding: 1rem 0.5rem;
      }
      .profil {
        padding: 1rem 0.5rem;
      }
      footer {
        flex-direction: column;
        gap: 1.5rem;
        border-radius: 1.2rem 1.2rem 0 0;
      }
    }
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
          <li><a href="nous.html">Qui sommes nous?</a></li>
          <li><a href="apropos.html">À propos</a></li>
          <li><a href="deconnexion.php" class="btn">Déconnexion</a></li>
          <li>
            <img class="logo-image2" src="bell.webp" alt="" id="notif-bell" style="height:22px; width:22px; object-fit:contain; vertical-align:middle;">
          </li>
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