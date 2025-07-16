<?php


if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST["nie"])) {
  $nie = trim(htmlspecialchars($_POST["nie"]));
  $id_club_basket = 3;

  try {
    $pdo = new PDO('mysql:host=localhost;dbname=p_transversal;charset=utf8mb4', 'root', 'Doja1390', [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // Chercher l'étudiant par NIE
    $stmt = $pdo->prepare("SELECT id_etudiant FROM ETUDIANT WHERE nie_etudiant = ?");
    $stmt->execute([$nie]);
    $etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($etudiant) {
      $id_etudiant = $etudiant['id_etudiant'];

      // Inscription dans S_inscrire (évite doublon avec INSERT IGNORE)
      $inscrire = $pdo->prepare("
                INSERT IGNORE INTO S_inscrire (id_club, id_etudiant, date_inscription_etudiant) 
                VALUES (?, ?, CURDATE())
            ");
      $inscrire->execute([$id_club_basket, $id_etudiant]);

      // Insertion aussi dans CLUB_ETUDIANT (selon ta base)
      $insertClubEtudiant = $pdo->prepare("
                INSERT IGNORE INTO CLUB_ETUDIANT (id_club, id_etudiant) 
                VALUES (?, ?)
            ");
      $insertClubEtudiant->execute([$id_club_basket, $id_etudiant]);

      // Mémoriser l'étudiant en session
      $_SESSION['id_etudiant'] = $id_etudiant;

      // Redirection vers profil.php
      header("Location: profil.php");
      exit();
    } else {
      $error_message = "NIE non trouvé dans la base.";
    }
  } catch (PDOException $e) {
    $error_message = "Erreur de base de données : " . htmlspecialchars($e->getMessage());
  }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>AVE BASKET</title>
  <link rel="stylesheet" href="basket.css">
</head>

<body>
  <div class="header">
    <div class="logo">
      <div class="logo-image"><img src="/pages/img/globe.png" alt="ESMIA University logo" /></div>
      <div class="logo-text"><a href="/accueil.php">ESMIA UNIVERSITY</a></div>

    </div>
    <div class="logo-line"></div>
  </div>

  <nav>
    <ul>
      <li><a href="accueil.php">Accueil</a></li>
      <li><a href="#clubs">Clubs</a></li>
      <li><a href="evenements.php">Événements</a></li>
      <li><a href="contact.php">Contact</a></li>
      <li><a href="apropos.html">A propos</a></li>
      <li>
        <a href="/pages/profil.php">
          <img src="<?= isset($_SESSION['user']['avatar']) ? $_SESSION['user']['avatar'] : 'user.png' ?>" class="avatar" alt="Profil">
        </a>
  
    </ul>
  </nav>

  <div>
    <h3 class="kobe">"If you are going to be a leader, you are not going to please everybody."<br>- KOBE BRYANT</h3>
  </div>

  <div class="interesse">
    <button onclick="openForm()">Intéressé ?</button>

  </div>
  <div class="form-popup" id="myForm">
    <form method="post" action="profil.php" class="form-container">
      <h1>Inscription</h1>

      <label for="identifiant"><b>NIE</b></label>
      <input type="text" placeholder="Enter NIE" name="nie" required>
      <button type="submit" class="btn">S'inscrire</button>
      <button type="button" class="btn cancel" onclick="closeForm()">Cancel</button>
    </form>

  </div>
  <script>
    function openForm() {
      document.getElementById("myForm").style.display = "block";
    }

    function closeForm() {
      document.getElementById("myForm").style.display = "none";
    }
  </script>

</body>

</html>