<?php
session_start();

try {
    $pdo = new PDO('mysql:host=localhost;dbname=p_transversal', 'root', 'Doja1390');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!isset($_SESSION['id_etudiant'])) {
        header("Location: login.php");
        exit();
    }

    $id = $_SESSION['id_etudiant'];

    // Vérifier si l'utilisateur est un admin
    $verif = $pdo->prepare("SELECT COUNT(*) FROM Admin_Club WHERE id_etudiant = ?");
    $verif->execute([$id]);
    if ($verif->fetchColumn() == 0) {
        echo "<p style='color:red;'>Accès refusé. Vous n'êtes pas un administrateur.</p>";
        exit();
    }

    // Récupérer les clubs administrés
    $stmt = $pdo->prepare("
        SELECT CLUB.id_club, CLUB.nom_club
        FROM CLUB
        JOIN Admin_Club ON CLUB.id_club = Admin_Club.id_club
        WHERE Admin_Club.id_etudiant = ?
    ");
    $stmt->execute([$id]);
    $clubs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $message = "";

    // Traitement de l'envoi du message
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['envoyer_broadcast'])) {
        $idClub = $_POST['club_message'];
        $objet = htmlspecialchars(trim($_POST['objet_message']));
        $contenu = htmlspecialchars(trim($_POST['contenu_message']));

        // Vérification que l'admin administre ce club
        $verifClub = $pdo->prepare("SELECT COUNT(*) FROM Admin_Club WHERE id_club = ? AND id_etudiant = ?");
        $verifClub->execute([$idClub, $id]);

        if ($verifClub->fetchColumn() == 0) {
            $message = "<p style='color:red;'>Ce club ne vous appartient pas.</p>";
        } else {
            // Récupérer tous les étudiants du club
            $etudiants = $pdo->prepare("SELECT id_etudiant FROM S_inscrire WHERE id_club = ?");
            $etudiants->execute([$idClub]);
            $recepteurs = $etudiants->fetchAll(PDO::FETCH_COLUMN);

            // Envoi du message à tous
            $stmt = $pdo->prepare("INSERT INTO MESSAGE (id_etudiant, contenu_message, objet_message) VALUES (?, ?, ?)");
            foreach ($recepteurs as $id_etudiant) {
                $stmt->execute([$id_etudiant, $contenu, $objet]);
            }

            $message = "<p style='color:green;'>📨 Message envoyé à <strong>" . count($recepteurs) . "</strong> étudiant(s).</p>";
        }
    }

} catch (PDOException $e) {
    $message = "<p style='color:red;'>Erreur : " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Broadcast - Admin</title>
  <link rel="stylesheet" href="admin.css"> <!-- si tu utilises un fichier CSS commun -->
  <style>
    body {
      background: linear-gradient(to right, #181c2f 60%, #a7a3ff 100%);
      font-family: 'Segoe UI', sans-serif;
      color: white;
      margin: 0;
    }

    header {
      background: #181c2f;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1rem 2rem;
    }

    .logo-text {
      font-size: 1.5rem;
      color: #6c63ff;
      font-weight: bold;
    }

    nav ul {
      display: flex;
      list-style: none;
      gap: 1.5rem;
    }

    nav ul li a {
      color: white;
      text-decoration: none;
      font-weight: bold;
      transition: 0.3s;
    }

    nav ul li a:hover {
      color: #a7a3ff;
    }

    main {
      max-width: 700px;
      margin: 3rem auto;
      background: rgba(255, 255, 255, 0.05);
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    h3 {
      text-align: center;
      color: #a7a3ff;
      margin-bottom: 1.5rem;
    }

    form label {
      display: block;
      margin: 1rem 0 0.5rem;
      color: white;
      font-weight: 600;
    }

    form select, form input[type="text"], form textarea {
      width: 100%;
      padding: 0.7rem;
      border-radius: 6px;
      border: none;
      font-size: 1rem;
    }

    form textarea {
      resize: vertical;
    }

    form input[type="submit"] {
      margin-top: 1.5rem;
      background: #6c63ff;
      color: white;
      border: none;
      padding: 0.8rem 1.2rem;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
    }

    .message {
      text-align: center;
      margin-top: 1rem;
    }
  </style>
</head>
<body>
  <header>
    <div class="logo-text">ESMIA UNIVERSITY</div>
    <nav>
      <ul>
        <li><a href="accueil.php">Accueil</a></li>
        <li><a href="profil.php">Profil</a></li>
        <li><a href="admin.php">evenements</a></li>
        <li><a href="deconnexion.php">Déconnexion</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <h3>📣 Envoyer un message à tous les membres d'un club</h3>
    <?php if (!empty($message)) echo "<div class='message'>$message</div>"; ?>

    <form method="post">
      <label for="club_message">Choisir le club :</label>
      <select name="club_message" required>
        <?php foreach ($clubs as $club): ?>
          <option value="<?= $club['id_club'] ?>"><?= htmlspecialchars($club['nom_club']) ?></option>
        <?php endforeach; ?>
      </select>

      <label for="objet_message">Objet du message :</label>
      <input type="text" name="objet_message" required>

      <label for="contenu_message">Contenu :</label>
      <textarea name="contenu_message" rows="4" required></textarea>

      <input type="submit" name="envoyer_broadcast" value="Envoyer le message">
    </form>
  </main>
</body>
</html>
