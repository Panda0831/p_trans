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
  <link rel="stylesheet" href="/view/acceuil.css/admin.css">
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
          <li><a href="/pages/accueil.php">Accueil</a></li>
          <li><a href="/pages/accueil.php#clubs">Clubs</a></li>
          <li><a href="/tsy important/nous.php">Qui sommes nous?</a></li>
          <li><a href="/tsy important/apropos.html">À propos</a></li>
          <li><a href="/pages/profil.php">
              <img src="<?= isset($_SESSION['user']['avatar']) ? $_SESSION['user']['avatar'] : 'user.png' ?>" class="avatar" alt="Profil">
          </a></li>
          <li>
          <img class="icon-nav" src="bell.webp" alt="Notifications" id="notif-bell">
          <img 
  class="icon-nav" 
  src="img/message.png" 
  alt="Messages" 
  id="notif-message" 
  onclick="window.location.href='messageAdmin.php';"
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
