<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = "localhost";
$user = "root";
$pass = "Doja1390";
$dbname = "p_transversal";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connexion échouée: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nom = trim($_POST["nom"] ?? '');
    $prenom = trim($_POST["prenom"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $nie = trim($_POST["nie"] ?? '');
    $password = $_POST["password"] ?? '';
    $confirm_password = $_POST["confirm_password"] ?? '';
    $filiere = trim($_POST["filiere"] ?? '');
    $niveau = trim($_POST["niveau"] ?? '');
    $classe = trim($_POST["classe"] ?? '');

    if ($nom === '' || $prenom === '' || $email === '' || $nie === '' || $password === '' || $confirm_password === '') {
        echo "<div style='color:red;text-align:center;'>Veuillez remplir tous les champs obligatoires.</div>";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<div style='color:red;text-align:center;'>Adresse email invalide.</div>";
        exit;
    }

    if ($password !== $confirm_password) {
        echo "<div style='color:red;text-align:center;'>Les mots de passe ne correspondent pas.</div>";
        exit;
    }

    // Unicité NIE
    $checkNIE = $conn->prepare("SELECT COUNT(*) FROM ETUDIANT WHERE nie_etudiant = ?");
    $checkNIE->execute([$nie]);
    if ($checkNIE->fetchColumn() > 0) {
        echo "<div style='color:red;text-align:center;'>Ce NIE est déjà utilisé.</div>";
        exit;
    }

    // Unicité Email
    $checkEmail = $conn->prepare("SELECT COUNT(*) FROM ETUDIANT WHERE email_etudiant = ?");
    $checkEmail->execute([$email]);
    if ($checkEmail->fetchColumn() > 0) {
        echo "<div style='color:red;text-align:center;'>Cet email est déjà utilisé.</div>";
        exit;
    }

    // Générer ID étudiant
    $query = "SELECT id_etudiant FROM ETUDIANT ORDER BY id_etudiant DESC LIMIT 1";
    $result = $conn->query($query);
    if ($result && $row = $result->fetch(PDO::FETCH_ASSOC)) {
        $lastId = $row['id_etudiant'];
        $num = (int)substr($lastId, 3);
        $num++;
        $id_etudiant = "ETU" . str_pad($num, 3, "0", STR_PAD_LEFT);
    } else {
        $id_etudiant = "ETU001";
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Insertion
    $sql = "INSERT INTO ETUDIANT (
        id_etudiant, nom_etudiant, prenom_etudiant, email_etudiant, nie_etudiant,
        filiere_etudiant, niveau_etudiant, classe_etudiant, password
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if ($stmt->execute([
        $id_etudiant, $nom, $prenom, $email, $nie,
        $filiere, $niveau, $classe, $passwordHash
    ])) {
        header("Location: liste.php");
        exit;
    } else {
        echo "<div style='color:red;text-align:center;'>Erreur lors de l'inscription : " . htmlspecialchars($stmt->errorInfo()[2]) . "</div>";
    }
}
?>




<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Inscription - Clubs ESMIA</title>
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
      background-color: var(--light-bg);
      color: rgb(51, 51, 51);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    header {
      background-color: white;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      padding: 15px 0;
      position: sticky;
      top: 0;
      z-index: 100;
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
      padding: 40px 0;
    }
    .container {
      background: rgb(78, 72, 158);
      padding: 40px 32px;
      border-radius: 16px;
      box-shadow: 0 6px 24px rgba(0,0,0,0.10);
      max-width: 500px;
      width: 100%;
      margin: 0 auto;
    }
    .container h1 {
      font-size: 2rem;
      color: var(--primary-color);
      margin-bottom: 5px;
      text-align: center;
    }
    .container h2 {
      font-size: 1rem;
      color: var(--secondary-color);
      margin-bottom: 30px;
      font-weight: normal;
      text-align: center;
    }
    .form-group {
      margin-bottom: 20px;
      text-align: left;
    }
    .form-group label {
      display: block;
      margin-bottom: 8px;
      color: var(--primary-color);
      font-weight: 600;
    }
    .form-group input,
    .form-group select {
      width: 100%;
      padding: 10px 15px;
      border: 1px solid #ddd;
      border-radius: 8px;
      background-color: #f0f0f0;
      color: #000;
      font-size: 0.95rem;
      box-sizing: border-box;
    }
    .form-group input:focus {
      outline: none;
      border: 1.5px solid var(--primary-color);
      background-color: #fff;
    }
    .submit-btn {
      width: 100%;
      padding: 14px;
      border: none;
      border-radius: 10px;
      background: var(--primary-color);
      color: #fff;
      font-size: 1rem;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s;
    }
    .submit-btn:hover {
      background: var(--secondary-color);
    }
    @media (max-width: 900px) {
      .header-container, footer {
        flex-direction: column;
        gap: 1.5rem;
        padding: 1rem;
      }
      .main-content {
        padding: 20px 5px;
      }
      .container {
        padding: 20px 8px;
      }
    }
    footer {
  background-color: var(--primary-color);
  color: white;
  font-size: large;
  padding: 2cm 0.5cm;
  justify-content: center;
  gap: 5cm;
  align-items: center;
  margin-top: 50px;
  display: flex;
}
footer li {
  opacity: 0.9;
  font-size: 0.9rem;
}
  </style>
</head>
<body>
  <header>
    <div class="header-container">
      <div class="logo">
        <div class="logo-image"><img src="./img/globe.png" alt="ESMIA University"></div>
        <div class="logo-text">ESMIA UNIVERSITY</div>
      </div>
      <nav>
        <ul>
          <li><a href="acceuil.php">Accueil</a></li>
          <li><a href="sosisy.php#clubs">Nos clubs</a></li>
          <li><a href="#">Événements</a></li>
          <li><a href="#">Profil</a></li>
          <li><a href="login.php" class="btn">Connexion</a></li>
        </ul>
      </nav>
    </div>
  </header>
  <div class="main-content">
    <div class="container">
      <h1>Formulaire</h1>
      <h2>Inscription</h2>
      <form method="post" action="inscription.php">
        <div class="form-group">
          <label for="nom">Nom :</label>
          <input type="text" id="nom" name="nom" required>
        </div>
        <div class="form-group">
          <label for="prenom">Prénom :</label>
          <input type="text" id="prenom" name="prenom" required>
        </div>
        <div class="form-group">
          <label for="email">Email :</label>
          <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
          <label for="nie">NIE :</label>
          <input type="text" id="nie" name="nie" required>
        </div>
        <div class="form-group">
          <label for="password">Mot de passe :</label>
          <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
          <label for="confirm_password">Confirmer le mot de passe :</label>
          <input type="password" id="confirm_password" name="confirm_password" required>
        </div>
        <div class="form-group">
          <label for="filiere">Filière :</label>
          <input type="text" id="filiere" name="filiere">
        </div>
        <div class="form-group">
          <label for="niveau">Niveau :</label>
          <input type="text" id="niveau" name="niveau">
        </div>
        <div class="form-group">
          <label for="classe">Classe :</label>
          <input type="text" id="classe" name="classe">
        </div>
        <button type="submit" class="submit-btn">S'inscrire</button>
      </form>
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