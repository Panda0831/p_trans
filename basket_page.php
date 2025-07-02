<?php
session_start();

$error_message = "";

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
  <style>
    :root {
      --primary-color: #721072;
      --hover-color: #007BFF;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-image: url('kobe-terrain.jpg');
      background-size: cover;
      position: relative;
      color: white;
    }


    .header {
      padding: 20px 40px;
    }

    .logo-container {
      width: 100%;
      max-width: 500px;
      overflow: hidden;
      margin-left: 1cm;
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

    .logo-text a {
      text-decoration: none;
    }

    .logo-line {
      width: 100%;
      height: 2px;
      background-color: var(--primary-color);
      margin-top: 6px;
    }

    nav {
      display: flex;
      justify-content: flex-end;
      margin-right: 4cm;
      margin-top: -1.5cm;
    }

    nav ul {
      display: flex;
      list-style: none;
      padding: 0;
      margin: 0;
    }

    nav ul li {
      margin-left: 30px;
    }

    nav ul li a {
      text-decoration: none;
      color: white;
      font-weight: 500;
      transition: color 0.3s ease;
      cursor: pointer;
    }

    nav ul li a:hover {
      color: var(--hover-color);

    }

    .kobe {


      margin-top: 6cm;
      margin-left: 9cm;
      font-size: 20px;
      text-shadow: 1px 1px 4px black;
      background: rgba(0, 0, 0, 0.10);
      padding: 20px;
      border-radius: 10px;
      max-width: 500px;
    }

    .interesse {
      margin-left: 9cm;
      margin-top: 20px;
    }

    .interesse button {
      height: 40px;
      width: 150px;
      text-transform: uppercase;
      font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
      font-size: 16px;
      background-color: #f0f0f0;
      border-radius: 5px;
      border: none;
      cursor: pointer;
      transition: all 0.3s ease;
      background-color: var(--primary-color);
      color: white;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.5);
    }

    .interesse button:hover {
      background-color: var(--hover-color);
      color: white;
      transform: scale(1.05);
    }

    @media (max-width: 768px) {

      .kobe,
      .interesse {
        margin-left: 1cm;
        margin-right: 1cm;
        text-align: center;
      }

      nav {
        justify-content: center;
        margin-right: 0;
      }
    }

    .globe {
      margin-right: 10px;

      width: 40px;
      height: 40px;
    }

    *,
    *::before,
    *::after {
      box-sizing: border-box;
    }

    /* Button used to open the contact form - fixed at the bottom of the page */
    .open-button {
      background-color: #555;
      color: white;
      padding: 16px 20px;
      border: none;
      cursor: pointer;
      opacity: 0.8;
      position: fixed;
      bottom: 23px;
      right: 28px;
      width: 280px;
    }

    /* The popup form - hidden by default */
    .form-popup {
      display: none;
      position: fixed;
      bottom: 0;
      right: 15px;
      border-radius: 3px rgb(9, 53, 141);
      z-index: 9;
      height: max-content;


    }

    /* Add styles to the form container */
    .form-container {
      max-width: 700px;
      padding: 50px;
      background-color: rgba(0, 0, 0, 0.80);
      ;
      border-radius: 10px;
      margin-right: 20cm;
      margin-bottom: 4.5cm;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);

    }

    /* Full-width input fields */
    .form-container input[type=text] {
      width: 100%;
      padding: 15px;
      margin: 5px 0 22px 0;
      border: none;
      background: #f1f1f1;
    }

    /* When the inputs get focus, do something */
    .form-container input[type=text]:focus {
      background-color: #ddd;
      outline: none;
    }

    /* Set a style for the submit/login button */
    .form-container .btn {
      background-color: #721072;
      color: white;
      padding: 16px 20px;
      border: none;
      cursor: pointer;
      width: 100%;
      margin-bottom: 10px;
      opacity: 0.8;
    }

    /* Add a red background color to the cancel button */
    .form-container .cancel {
      background-color: rgb(169, 64, 90);
    }

    /* Add some hover effects to buttons */
    .form-container .btn:hover,
    .open-button:hover {
      opacity: 1;
    }
  </style>
</head>

<body>
  <div class="header">
    <div class="logo">
      <div class="logo-image"><img src="globe.png" alt="ESMIA University logo" /></div>
      <div class="logo-text"><a href="accueil.php">ESMIA UNIVERSITY</a></div>

    </div>
    <div class="logo-line"></div>
  </div>

  <nav>
    <ul>
      <li><a href="profil.php">profil</a></li>

      <li><a href="accueil.php">Accueil</a></li>
      <li><a href="#clubs">Clubs</a></li>
      <li><a href="evenements.php">Événements</a></li>
      <li><a href="contact.php">Contact</a></li>
      <li><a href="login.php">Connexion</a></li>
    </ul>
  </nav>

  <div>
    <h3 class="kobe">"If you are going to be a leader, you are not going to please everybody."<br>- KOBE BRYANT</h3>
  </div>

  <div class="interesse">
    <button onclick="openForm()">Intéressé ?</button>

  </div>
  <div class="form-popup" id="myForm">
    <form method="post" action="/basket_page.php" class="form-container">
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