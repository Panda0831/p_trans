<?php
session_start();

$error = '';

try {
    $base = new PDO('mysql:host=localhost;dbname=p_transversal', 'root', 'Doja1390');
    $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (!empty($_POST["nie"]) && !empty($_POST["password"])) {
            $nie = htmlspecialchars(trim($_POST["nie"]));
            $password = trim($_POST["password"]);

            $query = $base->prepare("SELECT * FROM ETUDIANT WHERE nie_etudiant = ?");
            $query->execute([$nie]);
            $user = $query->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['id_etudiant'] = $user['id_etudiant'];
                $_SESSION['nom_etudiant'] = $user['nom_etudiant'];
                header("Location: profil.php");
                exit();
            } else {
                $error = "❌ Identifiant ou mot de passe incorrect.";
            }
        } else {
            $error = "⚠️ Veuillez remplir tous les champs.";
        }
    }
} catch (PDOException $e) {
    $error = "Erreur de connexion à la base de données : " . htmlspecialchars($e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Connexion</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
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
      line-height: 1.6;
      color: var(--text-color);
      background-color: var(--light-bg);
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
    .form-section {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 40px 0;
    }
    .form-container {
      background: #fff;
      padding: 40px 32px;
      border-radius: 16px;
      box-shadow: 0 6px 24px rgba(0,0,0,0.10);
      max-width: 400px;
      width: 100%;
    }
    h1 {
      color: var(--primary-color);
      margin-bottom: 24px;
      text-align: center;
    }
    .input-group {
      margin-bottom: 22px;
      text-align: left;
    }
    .input-group label {
      display: block;
      margin-bottom: 8px;
      color: var(--primary-color);
      font-weight: 600;
    }
    .input-group input {
      width: 100%;
      padding: 10px 15px;
      border: 1px solid #ddd;
      border-radius: 8px;
      background-color: #f0f0f0;
      color: #000;
      font-size: 1rem;
      box-sizing: border-box;
      transition: border 0.2s;
    }
    .input-group input:focus {
      outline: none;
      border: 1.5px solid var(--primary-color);
      background-color: #fff;
    }
    .btn-group {
      display: flex;
      gap: 18px;
      margin-top: 18px;
    }
    .btn-group button,
    .btn-group a {
      flex: 1;
      padding: 12px;
      border-radius: 8px;
      background: var(--primary-color);
      color: #fff;
      font-size: 1rem;
      font-weight: bold;
      cursor: pointer;
      text-align: center;
      text-decoration: none;
      line-height: 1.3;
      border: none;
      transition: background 0.3s;
      display: inline-block;
    }
    .btn-group button:hover,
    .btn-group a:hover {
      background: var(--secondary-color);
    }
    .error-message {
      color: #c00;
      margin-top: 10px;
      text-align: center;
    }footer {
      background-color: var(--primary-color);
      color: white;
      font-size: large;
      padding: 2cm 1rem;
      margin-top: 50px;
      width: 100vw;
      max-width: 100%;
      box-sizing: border-box;
      display: flex;
      justify-content: center;
      gap: 5cm;
      align-items: flex-start;
      flex-wrap: wrap;
    }

    footer ul {
      flex: 1 1 220px;
      min-width: 200px;
      margin: 0 1rem;
    }

    footer li {
      opacity: 0.9;
      font-size: 0.9rem;
    }

    @media (max-width: 900px) {
      footer {
      flex-direction: column;
      gap: 1.5rem;
      align-items: stretch;
      padding: 2rem 0.5rem;
      }
      footer ul {
      margin: 0.5rem 0;
      }
    }
  </style>
</head>
<body>
  <header>
    <div class="header-container">
      <div class="logo">
        <div class="logo-image"><img src="globe.png" alt="ESMIA University"></div>
        <div class="logo-text">ESMIA UNIVERSITY</div>
      </div>
      <nav>
        <ul style="display: flex;">
          <li style="margin-left: 30px;">
            <a href="sosisy.php" style="text-decoration:none;color:var(--text-color);font-weight:500;">Accueil</a>
          </li>
          <li style="margin-left: 30px;">
            <a href="sosisy.php#clubs" style="text-decoration:none;color:var(--text-color);font-weight:500;">Clubs</a>
          </li>
        </ul>
      </nav>
    </div>
  </header>

  <section class="form-section">
    <div class="form-container">
      <form action="" method="post" novalidate>
        <h1>Connexion</h1>
        <div class="input-group">
          <label for="nie">Identifiant :</label>
          <input type="text" id="nie" name="nie" placeholder="Entrez votre NIE" required value="<?= isset($_POST['nie']) ? htmlspecialchars($_POST['nie']) : '' ?>">
        </div>
        <div class="input-group">
          <label for="password">Mot de passe :</label>
          <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe" required>
        </div>
        <div class="btn-group">
          <a href="inscription.php">S'inscrire</a>
          <button type="submit">Se connecter</button>
        </div>
        <?php if ($error): ?>
          <div class="error-message"><?= $error ?></div>
        <?php endif; ?>
      </form>
    </div>
  </section>

  <footer>
    <ul>
      <p>Notre Equipe:</p>
      <li>@ 2025 ESMIA University</li>
      <li>Nexus Tech</li>
      <li>GROUPE 3 L1sio1</li>
    </ul>
    <ul>
      <p>Coordonnées:</p>
      <li>facebook</li>
      <li>Instagram</li>
      <li>Git Hub</li>
      <li>Esmia University</li>
    </ul>
    <ul>
      <p>Les Responsables :</p>
      <li>AVE President : Fanamby</li>
      <li>Secretaire : Willia Tang</li>
      <li>Trésorier : Ryan</li>
      <li>Conseiller : Joyce</li>
    </ul>
  </footer>
</body>
</html>
