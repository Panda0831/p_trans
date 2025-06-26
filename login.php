<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Connexion</title>
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
      position: relative;
    }

    .form-container {
      background: rgba(255, 255, 255, 0.08);
      padding: 40px;
      border-radius: 20px;
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.5);
      backdrop-filter: blur(15px);
      width: 100%;
      max-width: 450px;
      box-sizing: border-box;
    }

    .top-header {
      position: absolute;
      top: 15px;
      left: 30px;
      text-align: left;
    }

    .top-header h7 {
      font-size: 1.2rem;
      color: rgb(131, 149, 187);
      display: block;
      margin-bottom: 5px;
    }

    .top-header hr {
      border: 0;
      height: 1px;
      background: linear-gradient(495deg, #5f1f7a, #d02dc5);
      width: 150px;
      margin: 0;
      box-shadow: 0 0 10px rgba(30, 11, 11, 0.5);
      position: relative;
      bottom: -30px;
    }

    h1 {
      font-size: 2rem;
      color: #a3baff;
      margin-bottom: 10px;
    }

    .input-group {
      margin-bottom: 25px;
      text-align: left;
    }

    .input-group label {
      display: block;
      margin-bottom: 8px;
      color: #d58eff;
      font-weight: 600;
    }

    .input-group input {
      width: 100%;
      padding: 10px 15px;
      border: none;
      border-radius: 8px;
      background-color: #f0f0f0;
      color: #000;
      font-size: 0.95rem;
      box-sizing: border-box;
    }

    .input-group input:focus {
      outline: 2px solid #8a2be2;
      background-color: #fff;
    }

    .btn-group {
      display: flex;
      justify-content: space-between;
      gap: 20px;
      margin-top: 20px;
    }

    .btn-group button {
      flex: 1;
      padding: 12px;
      border: none;
      border-radius: 10px;
      background: linear-gradient(135deg, violet, #8a2be2);
      color: #fff;
      font-size: 1rem;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .btn-group button:hover {
      background: linear-gradient(135deg, #8a2be2, violet);
    }
  </style>
</head>
<body>

  <div class="top-header">
    <hr>
    <h7>ESMIA UNIVERSITY</h7>
  </div>

  <div class="form-container">
    <form action="" method="post">
      <h1>Connexion</h1>

      <div class="input-group">
        <label for="nie">Identifiant :</label>
        <input type="text" id="nie" name="nie" placeholder="Entrez votre NIE" required>
      </div>

      <div class="input-group">
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe" required>
      </div>

      <div class="btn-group">
        <button type="button" onclick="window.location.href='inscription.php'">Sign In</button>
        <button type="submit">Login</button>
      </div>
    </form>
  </div>
<?php
try {
    // Connexion à la base de données
    $base = new PDO('mysql:host=localhost;dbname=projet', 'root', '');
    $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "<p style='color: red;'>Erreur de connexion à la base de données : " . $e->getMessage() . "</p>";
    exit(); // Arrêter l'exécution si la connexion échoue
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["nie"], $_POST["password"]) && !empty($_POST["nie"]) && !empty($_POST["password"])) {
        $nie = htmlspecialchars($_POST["nie"]);
        $password = $_POST["password"];

        $query = $base->prepare("SELECT * FROM ETUDIANT WHERE nie_etudiant = ?");
        $query->execute([$nie]);
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if ($user && isset($user['password']) && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['id_etudiant'] = $user['id_etudiant'];
            $_SESSION['nom_etudiant'] = $user['nom_etudiant'];
            header("Location: acceuil.php");
            exit();
        } else {
            echo "<p style='color: red;'>Identifiant ou mot de passe incorrect.</p>";
        }
    } else {
        echo "<p style='color: red;'>Tous les champs sont obligatoires.</p>";
    }
}
?>

</body>
</html>
