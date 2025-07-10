<?php
session_start();

if (!isset($_SESSION['id_etudiant'])) {
    header("Location: login.php");
    exit();
}

// Redirection pour les admins
if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    header("Location: admin.php");
    exit();
}

// Connexion BDD
try {
    $pdo = new PDO('mysql:host=localhost;dbname=p_transversal', 'root', 'Doja1390');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id = $_SESSION['id_etudiant'];

    $stmt = $pdo->prepare("SELECT * FROM ETUDIANT WHERE id_etudiant = ?");
    $stmt->execute([$id]);
    $etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$etudiant) {
        echo '<p style="color:red;">Étudiant introuvable.</p>';
        exit();
    }

    $clubs_stmt = $pdo->prepare("
        SELECT CLUB.nom_club 
        FROM CLUB 
        JOIN S_inscrire ON CLUB.id_club = S_inscrire.id_club
        WHERE S_inscrire.id_etudiant = ?
    ");
    $clubs_stmt->execute([$id]);
    $clubs = $clubs_stmt->fetchAll(PDO::FETCH_COLUMN);

} catch (PDOException $e) {
    echo '<p style="color:red;">Erreur : ' . htmlspecialchars($e->getMessage()) . '</p>';
    exit();
}
?>

<!-- HTML ici pour afficher le profil étudiant -->

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Profil de <?= htmlspecialchars($etudiant['prenom_etudiant']) ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/view/profil.css">
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
          <li > <a href="evenement.php"></a></li>
          <li><a href="nous.php">Qui sommes nous?</a></li>
          <li><a href="apropos.html">À propos</a></li>
          <li><a href="profil.php">
          <a href="messages.php">
    <img src="img/message.png" class="logo-image2"  />
</a>
<a href="evenements.php">
<img class="icon-nav" src="bell.webp" alt="Notifications" id="notif-bell">
</a>

              <img src="<?= isset($_SESSION['user']['avatar']) ? $_SESSION['user']['avatar'] : 'user.png' ?>" class="avatar" alt="Profil">
          </li>
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
      </div>
      <a href="deconnexion.php" id="joda"> Se deconnecter</a>
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