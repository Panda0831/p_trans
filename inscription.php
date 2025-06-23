<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Connexion à la base de données
$host = "localhost";
$user = "root";
$pass = "Doja1390";
$dbname = "projet";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $email = $_POST["email"];
    $nie = $_POST["nie"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $filiere = $_POST["filiere"];
    $niveau = $_POST["niveau"];
    $classe = $_POST["classe"];

    if ($password !== $confirm_password) {
        echo "Les mots de passe ne correspondent pas.";
        exit;
    }

    $password = password_hash($password, PASSWORD_DEFAULT);
    $id_etudiant = uniqid("ETU");

    $sql = "INSERT INTO ETUDIANT (
        id_etudiant, nom_etudiant, prenom_etudiant, email_etudiant, nie_etudiant,
        filiere_etudiant, niveau_etudiant, classe_etudiant, password
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss",
        $id_etudiant, $nom, $prenom, $email, $nie,
        $filiere, $niveau, $classe, $password
    );

    if ($stmt->execute()) {
        header("Location: liste.php");
        exit;
    } else {
        echo "Erreur : " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Inscription</title>
  <style>
    body {
      font-family: sans-serif;
      background-image: url('89781.jpg');
      background-size: cover;
      background-position: center;
      color: #fff;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      text-align: center;
    }

    .container {
      background: rgba(255, 255, 255, 0.08);
      padding: 40px 50px;
      border-radius: 20px;
      box-shadow: 0 12px 30px rgba(167, 69, 194, 0.5);
      backdrop-filter: blur(15px);
      width: 90vw;
      max-width: 600px;
      box-sizing: border-box;
    }

    .container h1 {
      font-size: 2rem;
      color: #a3baff;
      margin-bottom: 5px;
    }

    .container h2 {
      font-size: 1rem;
      color: #d0d6f6;
      margin-bottom: 30px;
      font-weight: normal;
    }

    .form-group {
      margin-bottom: 20px;
      text-align: left;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      color: #d58eff;
      font-weight: 600;
    }

    .form-group input,
    .form-group select {
      width: 100%;
      padding: 10px 15px;
      border: none;
      border-radius: 8px;
      background-color: #f0f0f0;
      color: #000;
      font-size: 0.95rem;
      box-sizing: border-box;
    }

    .form-group input:focus {
      outline: 2px solid #8a2be2;
      background-color: #fff;
    }

    .submit-btn {
      width: 100%;
      padding: 14px;
      border: none;
      border-radius: 10px;
      background: linear-gradient(135deg, violet, #8a2be2);
      color: #fff;
      font-size: 1rem;
      font-weight: bold;
      cursor: pointer;
    }

    .submit-btn:hover {
      background: linear-gradient(135deg, #8a2be2, violet);
    }

    hr {
      border: 0;
      height: 1px;
      background: linear-gradient(495deg, #5f1f7a, #d02dc5);
      margin: 20px 0;
      width: 15%;
      box-shadow: 0 0 10px rgba(30, 11, 11, 0.5);
      position: absolute;
      top: 15px;
      left: 0;
    }

    h6{
      position: absolute;
      top: -4vh;
      left: 50px;
      font-size: 1.2rem;
      color: rgb(131, 149, 187);
    }
  </style>
</head>
<body>
  <hr>
  <h6>ESMIA UNIVERSITY</h6>
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
        <input type="password" id="confirm-password" name="confirm_password" required>
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
</body>
</html>
