



<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
      width: 1000vh;
      max-width: 100vh;
      box-sizing: border-box;
    }
    .container h1 {
      font-size: 2rem;
      color: #a3baff;
      margin-bottom: 5px;
      text-align: center;
    }
    .container h2 {
      font-size: 1rem;
      color: #d0d6f6;
      margin-bottom: 30px;
      text-align: center;
      font-weight: normal;
    }
    .form-group {
      margin-bottom: 25px;
      text-align: left;
    }
    .form-group label {
      display: block;
      margin-bottom: 8px;
      color: #d58eff;
      font-weight: 600;
    }
    .form-group input {
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
      transition: background 0.3s ease;
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
    h7 {
      position: absolute;
      top: 10px;
      left: 50px;
      font-size: 1.2rem;
      margin-bottom: 10px;
      color: rgb(131, 149, 187);
    }
  </style>
</head>
<body>
  <hr>
  <h7>ESMIA UNIVERSITY</h7>
  <div class="container">
    <h1>Formulaire</h1>
    <h2>Inscription</h2>
    <form method="post" action="inscrition.php">
      <div class="form-group">
        <label for="nom">Nom et Prénoms :</label>
        <input type="text" id="nom" name="nom" required>
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
        <label for="confirm-password">Confirmer le mot de passe :</label>
        <input type="password" id="confirm-password" name="confirm-password" required>
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
    <?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "Doja1390";
$dbname = "p_trans"; 

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Vérifier si le formulaire a été soumis
if (isset($_POST['nom'], $_POST['email'], $_POST['nie'], $_POST['password'])) {
    $nom = htmlspecialchars($_POST['nom']);
    $email = htmlspecialchars($_POST['email']);
    $nie = htmlspecialchars($_POST['nie']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // hash sécurisé
    $filiere = htmlspecialchars($_POST['filiere'] ?? '');
    $niveau = htmlspecialchars($_POST['niveau'] ?? '');
    $classe = htmlspecialchars($_POST['classe'] ?? '');
    // Vérifier si les champs sont vides
    if (empty($nom) || empty($email) || empty($nie) || empty($_POST['password'])) {
        echo "Tous les champs sont obligatoires.";
        exit;
    }

    // Préparer et exécuter la requête
    $stmt = $conn->prepare("INSERT INTO ETUDIANT (nom, email, nie, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nom, $email, $nie, $password);
    if ($_POST['password'] !== $_POST['confirm-password']) {
        echo "Les mots de passe ne correspondent pas.";
        exit;
    }//completer les champs
    if(empty($nom) || empty($email) || empty($nie) || empty($_POST['password'])) {
        echo "Tous les champs sont obligatoires.";
        exit;
    }
    //verie si le nie existe déjà
    $stmtCheck = $conn->prepare("SELECT * FROM ETUDIANT WHERE nie = ?");
    $stmtCheck->bind_param("s", $nie);
    $stmtCheck->execute();
    $result = $stmtCheck->get_result();
    if ($result->num_rows > 0) {
        echo "Le NIE existe déjà.";
        exit;
    }
    $stmtCheck->close();


    if ($stmt->execute()) {
        echo "Inscription réussie.";
        header("Location: login.php");
    } else {
        echo " Erreur : " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>


    </form>
  </div>
</body>
</html>
