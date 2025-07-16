<?php

ini_set('session.save_path', '/tmp');
session_start();

// 🔍 Affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
try {
    $pdo = new PDO('mysql:host=localhost;dbname=aaa', 'root', 'Ryan');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupération des événements
    $stmt = $pdo->query("SELECT nom_evenement, description_evenement, date_evenement, lieu_evenement 
                         FROM EVENEMENT 
                         ORDER BY date_evenement DESC");
    $evenements = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erreur de connexion : " . htmlspecialchars($e->getMessage()));
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="event.css">
  <title>Événements - Clubs ESMIA</title>
  <style>
  
  </style>
</head>
<body>

  <header>
    <div class="header-container">
      <div class="logo">
        <div class="logo-image"><img src="./img/globe.webp" alt="ESMIA University" /></div>
        <div class="logo-text">ESMIA UNIVERSITY</div>
      </div>
      <nav>
        <ul>
          <li><a href="accueil.php">Accueil</a></li>
          <li><a href="#clubs">Clubs</a></li>
          <li><a href="nous.php">Qui sommes nous?</a></li>
          <li style="color: white;"><a href="apropos.php">À propos</a></li>
          <li>
            <a href="profil.php">
              <img src="<?= isset($_SESSION['user']['avatar']) ? $_SESSION['user']['avatar'] : 'user.png' ?>" class="avatar" alt="Profil" />
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </header>

  <main>
    <section>
      <?php foreach ($evenements as $event): ?>
        <div class="card">
          <img src="./img/event1.jpg" alt="Image événement">
          <div class="card-content">
            <h3><?= htmlspecialchars($event['nom_evenement']) ?></h3>
            <p><?= nl2br(htmlspecialchars($event['description_evenement'])) ?></p>
            <p class="date">📅 <?= htmlspecialchars($event['date_evenement']) ?> | 📍 <?= htmlspecialchars($event['lieu_evenement']) ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </section>
  </main>

  <footer>
    <ul>
      <p>Notre Équipe :</p>
      <li>@ 2025 ESMIA University</li>
      <li><a href="https://github.com/nexus-tech5">Nexus Tech</a></li>
      <li>GROUPE 3 L1SIO1</li>
    </ul>
    <ul>
      <p>Coordonnées :</p>
      <li>Facebook</li>
      <li>Instagram</li>
      <li>GitHub</li>
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
