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

    // Récupérer les clubs administrés par l'utilisateur
    $stmt = $pdo->prepare("
        SELECT CLUB.id_club, CLUB.nom_club
        FROM CLUB
        JOIN Admin_Club ON CLUB.id_club = Admin_Club.id_club
        WHERE Admin_Club.id_etudiant = ?
    ");
    $stmt->execute([$id]);
    $clubs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $message = "";

    // Traitement de l'envoi de message broadcast
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['envoyer_broadcast'])) {
        $idClub = $_POST['club_message'];
        $objet = htmlspecialchars(trim($_POST['objet_message']));
        $contenu = htmlspecialchars(trim($_POST['contenu_message']));

        // Vérifie si l'admin a bien le droit d'administrer ce club
        $verifClub = $pdo->prepare("SELECT COUNT(*) FROM Admin_Club WHERE id_club = ? AND id_etudiant = ?");
        $verifClub->execute([$idClub, $id]);

        if ($verifClub->fetchColumn() == 0) {
            $message = "<p style='color:red;'>Ce club ne vous appartient pas.</p>";
        } else {
            // Récupère tous les étudiants inscrits dans ce club
            $etudiants = $pdo->prepare("SELECT id_etudiant FROM S_inscrire WHERE id_club = ?");
            $etudiants->execute([$idClub]);
            $recepteurs = $etudiants->fetchAll(PDO::FETCH_COLUMN);

            // Préparer une seule fois la requête
            $stmt = $pdo->prepare("INSERT INTO MESSAGE (id_etudiant, contenu_message, objet_message, vu) VALUES (?, ?, ?, 0)");

            foreach ($recepteurs as $id_etudiant) {
                $stmt->execute([$id_etudiant, $contenu, $objet]);
            }

            $message = "<p style='color:green;'>Message envoyé à <strong>" . count($recepteurs) . "</strong> étudiant(s).</p>";
        }
    }

} catch (PDOException $e) {
    $message = "<p style='color:red;'>Erreur de base de données : " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Broadcast - Admin</title>
<link rel="stylesheet" href="/view/acceuil.css/message.css">  <style>
  
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
