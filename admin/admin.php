<?php
session_start();

try {
    // Connexion à la base
    $pdo = new PDO('mysql:host=localhost;dbname=p_transversal', 'root', 'Doja1390');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérifie que l'utilisateur est connecté
    if (!isset($_SESSION['id_etudiant'])) {
        header('Location: login.php');
        exit();
    }

    $id = $_SESSION['id_etudiant'];

    // Vérifie si c'est un admin
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM Admin_Club WHERE id_etudiant = ?");
    $stmt->execute([$id]);
    $isAdmin = $stmt->fetchColumn() > 0;

    // Empêche l'accès si ce n'est pas un admin
    if (!$isAdmin) {
        header('Location: profil.php'); // Redirige vers page étudiant si non admin
        exit();
    }

    // Récupérer les clubs que l'admin gère
    $clubs_stmt = $pdo->prepare("
        SELECT CLUB.id_club, CLUB.nom_club 
        FROM CLUB
        JOIN Admin_Club ON CLUB.id_club = Admin_Club.id_club
        WHERE Admin_Club.id_etudiant = ?
    ");
    $clubs_stmt->execute([$id]);
    $clubs = $clubs_stmt->fetchAll(PDO::FETCH_ASSOC);

    // Traitement de l'ajout d'événement
    $message = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter_evenement'])) {

        // Protection & nettoyage
        $nom         = htmlspecialchars(trim($_POST['nom_evenement']));
        $date        = $_POST['date_evenement'];
        $heure       = $_POST['heure_evenement'];
        $lieu        = htmlspecialchars(trim($_POST['lieu_evenement']));
        $finInscription = $_POST['date_fin_inscription'];
        $lancement   = $_POST['date_lancement'];
        $description = htmlspecialchars(trim($_POST['description_evenement']));
        $idClub      = intval($_POST['id_club']);
        $image       = trim($_POST['image_evenement']);

        // Valeur par défaut pour l'image si vide
        if (empty($image)) {
            $image = 'https://cdn.pixabay.com/photo/2020/05/08/16/19/event-5142104_960_720.jpg';
        }

        // Requête d’insertion
        $insert = $pdo->prepare("
            INSERT INTO EVENEMENT (
                id_club, nom_evenement, date_evenement, heure_evenement,
                lieu_evenement, date_fin_inscription, date_lancement, image_evenement, description_evenement
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $ok = $insert->execute([
            $idClub, $nom, $date, $heure,
            $lieu, $finInscription, $lancement, $image, $description
        ]);
        if ($ok) {
          // 🔔 Envoie les notifications aux membres du club
          $idEvenement = $pdo->lastInsertId();
          $etudiants = $pdo->prepare("SELECT id_etudiant FROM S_inscrire WHERE id_club = ?");
          $etudiants->execute([$idClub]);
      
          foreach ($etudiants->fetchAll(PDO::FETCH_COLUMN) as $id_etud) {
              $pdo->prepare("INSERT INTO NOTIFICATION_EVENEMENT (id_etudiant, id_evenement) VALUES (?, ?)")
                   ->execute([$id_etud, $idEvenement]);
          }
      
          $message = "<p style='color:green;'>Événement ajouté avec succès et notifications envoyées.</p>";
      } else {
          $message = "<p style='color:red;'>Erreur lors de l'ajout de l’événement.</p>";
      }
      

        $message = $ok 
            ? "<p style='color:green;'>✅ Événement ajouté avec succès.</p>" 
            : "<p style='color:red;'>❌ Erreur lors de l'ajout.</p>";
    }

} catch (PDOException $e) {
    echo "<p style='color:red;'>Erreur de base de données : " . htmlspecialchars($e->getMessage()) . "</p>";
    exit();
}

?>



<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Espace Admin</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background:rgb(152, 135, 196);
      margin: 0;
      padding: 2rem;
    }
    h1 { color: #333; }
    form, .clubs { background: #fff; padding: 20px; margin-bottom: 20px; border-radius: 10px; }
    label {
      display: block;
      margin-top: 10px;
      background: #6c63ff;
      color: var(--white);
      padding: 6px 12px;
      border-radius: 6px;
      font-weight: 500;
      margin-bottom: 6px;
      width: fit-content;
      box-shadow: 0 2px 8px #6c63ff22;
    }
    input[type="text"], input[type="date"], input[type="time"] {
      width: 100%; padding: 8px; margin-top: 5px;
    }
    input[type="submit"] {
      background: #007BFF; color: white; padding: 10px 15px;
      border: none; margin-top: 15px; border-radius: 5px;
    }
  </style>
</head>
<style>:root {
      --main-bg: #181c2f;
      --accent: #6c63ff;
      --accent-light: #a7a3ff;
      --white: #fff;
      --gray:rgb(88, 31, 31);
      --text: #232946;
      --shadow: 0 8px 32px 0 rgba(140, 33, 202, 0.18);
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
      background: rgba(24, 28, 47, 0.95);
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

    nav ul li a:hover,
    nav ul li a.btn:hover {
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
      background: rgba(255, 255, 255, 0.09);
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

    footer li,
    footer a {
      color: #fff;
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

    .avatar {
      width: 40px;
      height: 39px;
      border-radius: 50%;
      object-fit: cover;
      cursor: pointer;
      border: 2px solid white;

    }

    #joda {
      background: var(--accent-light);
      color: var(--main-bg);
      background: var(--accent);
      color: var(--white);
      padding: 0.6rem 1.2rem;
      border-radius: 6px;
      text-decoration: none;
      font-weight: 600;
     
      letter-spacing: 0.5px;
      transition: background 0.2s, color 0.2s;
      border: none;
      cursor: pointer;
      box-shadow: 0 2px 8px #6c63ff33;
      display: inline-block;
      text-align: center;
      position: relative;
      left:17vh;
      font-weight: bold;
    
    }
    /* Icônes de navigation (cloche, message, etc.) */
.icon-nav {
  height: 22px;
  width: 22px;
  object-fit: contain;
  vertical-align: middle;
  cursor: pointer;
  margin-left: 15px;
  transition: transform 0.2s ease;
}

.icon-nav:hover {
  transform: scale(1.2);
}

    
    </style>
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
          <li><a href="nous.php">Qui sommes nous?</a></li>
          <li><a href="apropos.html">À propos</a></li>
          <li><a href="profil.php">
              <img src="<?= isset($_SESSION['user']['avatar']) ? $_SESSION['user']['avatar'] : 'user.png' ?>" class="avatar" alt="Profil">
          </a></li>
          <li>
          <img class="icon-nav" src="bell.webp" alt="Notifications" id="notif-bell">
          <img 
  class="icon-nav" 
  src="img/message.png" 
  alt="Messages" 
  id="notif-message" 
  onclick="window.location.href='message.php';"
>          </li>
        </ul>
      </nav>
    </div>
  </header>
  <div class="main-content">
    <div class="profil" style="max-width:600px;width:100%;">
      <h2>Espace Administrateur</h2>
      <?php if (isset($message)) echo $message; ?>
      <div class="clubs-list">
        <strong>Clubs administrés :</strong>
        <ul>
          <?php foreach ($clubs as $club): ?>
            <li><?= htmlspecialchars($club['nom_club']) ?> (ID: <?= $club['id_club'] ?>)</li>
          <?php endforeach; ?>
        </ul>
        <h3>Ajouter un événement</h3>
      </div>
      
      <form method="post" style="background-color: rgba(42, 5, 59, 0.19);">
        <label for="id_club">Choisir le club :</label>
        <select name="id_club" required>
          <?php foreach ($clubs as $club): ?>
            <option value="<?= $club['id_club'] ?>"><?= htmlspecialchars($club['nom_club']) ?></option>
          <?php endforeach; ?>
        </select>

        <label>Nom de l’événement :</label>
        <input type="text" name="nom_evenement" required>

        <label>Date :</label>
        <input type="date" name="date_evenement" required>

        <label>Heure :</label>
        <input type="time" name="heure_evenement" required>
        <label>Description :</label>
        <input type="text" name="description_evenement" required>

        <label>Lieu :</label>
        <input type="text" name="lieu_evenement" required>

        <label>Date fin inscription :</label>
        <input type="date" name="date_fin_inscription" required>

        <label>Date de lancement :</label>
        <input type="date" name="date_lancement" required>
        <label for="image_evenement">Image (URL) :</label>
<input type="text" name="image_evenement" placeholder="https://...">


        <input type="submit" name="ajouter_evenement" value="Ajouter l’événement">
      </form>
      <div class="logout" style="margin-top:2rem;">
        <a href="deconnexion.php" id="joda">Se déconnecter</a>
      </div>
      <div style="margin-top:1.5rem;text-align:center;">
        <a href="profil.php" style="color:var(--accent-light);text-decoration:underline;font-weight:bold;">← Retour au profil</a>
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
